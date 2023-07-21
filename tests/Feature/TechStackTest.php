<?php

namespace Tests\Feature;

use App\Filament\Resources\TechStackResource as ResourcesTechStackResource;
use App\Filament\Resources\TechStackResource\Pages\CreateTechStack;
use App\Filament\Resources\TechStackResource\Pages\EditTechStack;
use App\Filament\Resources\TechStackResource\Pages\ListTechStacks;
use App\Models\TechStack;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->stack = TechStack::factory()->make();
});

it('can render page', function () {
    $this->get(ResourcesTechStackResource::getUrl())->assertStatus(200);
});

it('can list all', function () {
    $stacks = TechStack::factory(10)->create();

    livewire(ListTechStacks::class)
        ->assertCanSeeTableRecords($stacks);
});

it('can create', function () {
    livewire(CreateTechStack::class)
        ->fillForm([
            'font' => $this->stack->font,
            'color' => $this->stack->color,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can edit', function () {
    $savedStack = TechStack::factory()->create();

    livewire(EditTechStack::class, [
        'record' => $savedStack->getKey(),
    ])
        ->fillForm([
            'font' => $this->stack->font,
            'color' => $this->stack->color,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($savedStack->refresh())
            ->font->toBe($this->stack->font)
            ->color->toBe($this->stack->color);
});

it('can delete', function () {
    $savedStack = TechStack::factory()->create();

    livewire(EditTechStack::class, [
        'record' => $savedStack->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($savedStack);
});

test('API: can list all', function () {
    TechStack::factory(10)->create();
    $response = $this->get(route('stacks.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.stacks', 10)
            ->has('data.stacks.0', fn ($json) => $json->hasAll(['id', 'font', 'color'])
            )
    );
});
