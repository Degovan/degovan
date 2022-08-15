<?php

use App\Filament\Resources\FaqResource;
use App\Filament\Resources\FaqResource\Pages\CreateFaq;
use App\Filament\Resources\FaqResource\Pages\EditFaq;
use App\Filament\Resources\FaqResource\Pages\ListFaqs;
use App\Models\Faq;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->faq = Faq::factory()->make();
});

it('can render page', function () {
    $this->get(FaqResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function () {
    $faqs = Faq::factory(10)->create();

    livewire(ListFaqs::class)
        ->assertCanSeeTableRecords($faqs);
});

it('can create', function () {
    livewire(CreateFaq::class)
        ->fillForm([
            'question' => $this->faq->question,
            'answer' => $this->faq->answer,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can edit', function () {
    $savedFaq = Faq::factory()->create();

    livewire(EditFaq::class, [
        'record' => $savedFaq->getKey(),
    ])
        ->fillForm([
            'question' => $this->faq->question,
            'answer' => $this->faq->answer,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($savedFaq->refresh())
            ->question->toBe($this->faq->question)
            ->answer->toBe($this->faq->answer);
});

it('can delete', function () {
    $savedFaq = Faq::factory()->create();

    livewire(EditFaq::class, [
        'record' => $savedFaq->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($savedFaq);
});

test('API: can list all', function () {
    Faq::factory(10)->create();
    $response = $this->get(route('faqs.index'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('meta')
            ->has('data')
            ->has('data.faqs', 10)
            ->has('data.faqs.0', fn ($json) => $json->hasAll(['id', 'question', 'answer'])
            )
    );
});
