<?php

namespace Tests\Feature;

use App\Filament\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\UploadedFile;
use App\Filament\Resources\TestimonialResource\Pages\{CreateTestimonial, EditTestimonial, ListTestimonials};
use Filament\Pages\Actions\DeleteAction;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->testimo = Testimonial::factory()->make();
    $this->photo = UploadedFile::fake()->image('avatar.png');
});

it('can render page', function () {
    $this->get(TestimonialResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function () {
    $testimonials = Testimonial::factory(10)->create();

    livewire(ListTestimonials::class)
        ->assertCanSeeTableRecords($testimonials);
});

it('can create', function () {
    livewire(CreateTestimonial::class)
    ->fillForm([
        'name' => $this->testimo->name,
        'label' => $this->testimo->label,
        'quote' => $this->testimo->quote,
    ])
    ->set('data.photo', [$this->photo])
    ->call('create')
    ->assertHasNoFormErrors();
});

it('can edit', function() {
    $saveTestimo = Testimonial::factory()->create();


    livewire(EditTestimonial::class, [
        'record' => $saveTestimo->getKey(),
    ])
        ->fillForm([
            'name' => $this->testimo->name,
            'label' => $this->testimo->label,
            'quote' => $this->testimo->quote,
        ])
        ->set('data.photo', [$this->photo])
        ->call('save')
        ->assertHasNoFormErrors();

        expect($saveTestimo->refresh())
                ->name->toBe($this->testimo->name)
                ->label->toBe($this->testimo->label)
                ->quote->toBe($this->testimo->quote);
});

it('can deleted', function() {
    $saveTestimo = Testimonial::factory()->create();

    Livewire(EditTestimonial::class, [
        'record' => $saveTestimo->getKey(),
    ])
        ->callPageAction(
            DeleteAction::class
        );

    $this->assertModelMissing($saveTestimo);
});
