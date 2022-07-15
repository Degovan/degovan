<?php

use App\Filament\Resources\PortfolioResource;
use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->porto = Portfolio::factory()->make();
    $this->image = UploadedFile::fake()->image('avatar.png');
});

it('can render page', function () {
    $this->get(PortfolioResource::getUrl())->assertStatus(200);
});

it('can list all', function () {
    $portfolios = Portfolio::factory(10)->create();

    livewire(Pages\ListPortfolios::class)
        ->assertCanSeeTableRecords($portfolios);
});

it('can create', function () {
    livewire(Pages\CreatePortfolio::class)
        ->fillForm([
            'name' => $this->porto->name,
            'date' => $this->porto->date,
            'description' => $this->porto->description,
        ])
        ->set('data.images', [$this->image])
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can edit', function () {
    $savedPorto = Portfolio::factory()->create();

    livewire(Pages\EditPortfolio::class, [
        'record' => $savedPorto->getKey(),
    ])
        ->fillForm([
            'name' => $this->porto->name,
            'date' => $this->porto->date,
            'description' => $this->porto->description,
        ])
        ->set('data.images', [$this->image])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($savedPorto->refresh())
            ->name->toBe($this->porto->name)
            ->slug->toBe(Str::slug($this->porto->name))
            ->date->toBe($this->porto->date)
            ->description->toBe($this->porto->description);
});

it('can delete', function () {
    $savedPorto = Portfolio::factory()->create();

    livewire(Pages\EditPortfolio::class, [
        'record' => $savedPorto->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($savedPorto);
});

test('API: can list all', function () {
    Portfolio::factory(10)->create();
    $response = $this->get(route('portfolios.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.portfolios', 10)
            ->has('data.portfolios.0', fn ($json) => $json->hasAll(['id', 'name', 'slug', 'images'])
            )
    );
});

test('API: can show detail', function () {
    $savedCont = Portfolio::factory()->create();
    $response = $this->get(route('portfolios.show', $savedCont));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data', fn ($json) => $json->hasAll(['id', 'name', 'slug', 'images', 'date', 'description'])
            )
    );
});
