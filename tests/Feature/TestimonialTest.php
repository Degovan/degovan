<?php

namespace Tests\Feature;

use App\Filament\Resources\TestimonialResource;
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Models\Testimonial;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
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

it('can edit', function () {
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

it('can deleted', function () {
    $saveTestimo = Testimonial::factory()->create();

    Livewire(EditTestimonial::class, [
        'record' => $saveTestimo->getKey(),
    ])
        ->callPageAction(
            DeleteAction::class
        );

    $this->assertModelMissing($saveTestimo);
});


test('API: can list all', function () {
    Testimonial::factory(10)->create();
    $response = $this->get(route('testimonials.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.testimonials', 10)
            ->has('data.testimonials.0', fn ($json) => $json->hasAll(['id', 'name', 'photo', 'label', 'quote'])
            )
    );
});

test('API: can show detail', function () {
    $savedCont = Testimonial::factory()->create();
    $response = $this->get(route('testimonials.show', $savedCont));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data', fn ($json) => $json->hasAll(['id', 'name', 'photo', 'label', 'quote'])
            )
    );
});
