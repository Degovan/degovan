<?php

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Http\UploadedFile;
use function Pest\Livewire\livewire;

beforeEach(function() {
    $this->client = Client::factory()->make();
    $this->logo = UploadedFile::fake()->image('logo.png');
});

it('can render page', function() {
    $this->get(ClientResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function() {
    $clients = Client::factory(10)->create();

    livewire(Pages\ListClients::class)
        ->assertCanSeeTableRecords($clients);
});

it('can create', function() {
    livewire(Pages\CreateClient::class)
        ->fillForm([
            'name' => $this->client->name,
        ])
        ->set('data.logo', $this->logo)
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can edit', function () {
    $savedClient = Client::factory()->create();

    livewire(Pages\EditClient::class, [
        'record' => $savedClient->getKey(),
    ])
        ->fillForm([
            'name' => $this->client->name,
        ])
        ->set('data.logo', $this->logo)
        ->call('save')
        ->assertHasNoFormErrors();

    expect($savedClient->refresh())
            ->name->toBe($this->client->name)
            ->role->toBe($this->client->role)
            ->quotes->toBe($this->client->quotes);
});

it('can delete', function () {
    $savedClient = Client::factory()->create();

    livewire(Pages\EditClient::class, [
        'record' => $savedClient->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($savedClient);
});
