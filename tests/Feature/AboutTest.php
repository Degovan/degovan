<?php

namespace Tests\Feature;

use App\Filament\Resources\AboutResource;
use App\Filament\Resources\AboutResource\Pages\CreateAbout;
use App\Filament\Resources\AboutResource\Pages\EditAbout;
use App\Filament\Resources\AboutResource\Pages\ListAbouts;
use App\Models\About;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->abouts = About::factory()->make();
    $this->banner = UploadedFile::fake()->image('avatar.png');
    $this->attach = UploadedFile::fake()->create('document.pdf', 5000, 'application/pdf');
});

it('can render page', function () {
    $this->get(AboutResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function () {
    $abouts = About::factory(10)->create();

    livewire(ListAbouts::class)
        ->assertCanSeeTableRecords($abouts);
});

it('can create', function () {
    livewire(CreateAbout::class)
    ->fillForm([
        'vision' => $this->abouts->vision,
        'mission' => $this->abouts->mission,
    ])
    ->set('data.banner', [$this->banner])
    ->set('data.attachment', [$this->attach])
    ->call('create')
    ->assertHasNoFormErrors();
});

it('can edit', function () {
    $saveAbouts = About::factory()->create();

    livewire(EditAbout::class, [
        'record' => $saveAbouts->getKey(),
    ])
        ->fillForm([
            'vision' => $this->abouts->vision,
            'mission' => $this->abouts->mission,
        ])
        ->set('data.banner', [$this->banner])
        ->set('data.attachment', [$this->attach])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($saveAbouts->refresh())
                ->vision->toBe($this->abouts->vision)
                ->mission->toBe($this->abouts->mission);
});

it('can deleted', function () {
    $saveAbouts = About::factory()->create();

    Livewire(EditAbout::class, [
        'record' => $saveAbouts->getKey(),
    ])
        ->callPageAction(
            DeleteAction::class
        );

    $this->assertModelMissing($saveAbouts);
});

test('API: can list all', function () {
    About::factory(10)->create();
    $response = $this->get(route('abouts.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.abouts', 10)
            ->has('data.abouts.0', fn ($json) => $json->hasAll([
                'id', 'vision', 'mission', 'banner', 'attachment',
            ])
            )
    );
});
