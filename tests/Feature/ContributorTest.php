<?php

use App\Filament\Resources\ContributorResource;
use App\Filament\Resources\ContributorResource\Pages;
use App\Models\Contributor;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->cont = Contributor::factory()->make();
    $this->photo = UploadedFile::fake()->image('avatar.png');
});

it('can render page', function () {
    $this->get(ContributorResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function () {
    $contributors = Contributor::factory(10)->create();

    livewire(Pages\ListContributors::class)
        ->assertCanSeeTableRecords($contributors);
});

it('can create', function () {
    livewire(Pages\CreateContributor::class)
        ->fillForm([
            'name' => $this->cont->name,
            'role' => $this->cont->role,
            'quotes' => $this->cont->quotes,
        ])
        ->set('data.photo', $this->photo)
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can edit', function () {
    $savedCont = Contributor::factory()->create();

    livewire(Pages\EditContributor::class, [
        'record' => $savedCont->getKey(),
    ])
        ->fillForm([
            'name' => $this->cont->name,
            'role' => $this->cont->role,
            'quotes' => $this->cont->quotes,
        ])
        ->set('data.photo', $this->photo)
        ->call('save')
        ->assertHasNoFormErrors();

    expect($savedCont->refresh())
            ->name->toBe($this->cont->name)
            ->role->toBe($this->cont->role)
            ->quotes->toBe($this->cont->quotes);
});

it('can delete', function () {
    $savedCont = Contributor::factory()->create();

    livewire(Pages\EditContributor::class, [
        'record' => $savedCont->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($savedCont);
});

test('API: can list all', function () {
    Contributor::factory(10)->create();
    $response = $this->get(route('contributors.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.contributors', 10)
            ->has('data.contributors.0', fn ($json) => $json->hasAll(['id', 'name', 'photo', 'role', 'quotes'])
            )
    );
});

test('API: can show detail', function () {
    $savedCont = Contributor::factory()->create();
    $response = $this->get(route('contributors.show', $savedCont));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data', fn ($json) => $json->hasAll(['id', 'name', 'photo', 'role', 'quotes'])
            )
    );
});
