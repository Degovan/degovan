<?php

use App\Filament\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Filament\Resources\InvoiceResource\Pages;
use Filament\Pages\Actions\DeleteAction;

use function Pest\Livewire\livewire;

beforeEach(fn() => $this->invoice = Invoice::factory()->make());

it('can render the page', function() {
    $this->get(InvoiceResource::getUrl('index'))->assertStatus(200);
});

it('can list all', function() {
    $invoices = Invoice::factory(10)->create();

    livewire(Pages\ListInvoices::class)
        ->assertCanSeeTableRecords($invoices);
});

it('can create', function() {
    livewire(Pages\CreateInvoice::class)
        ->fillForm($this->invoice->toArray())
        ->assertHasNoFormErrors();
});

it('can edit', function() {
    $invoice = Invoice::factory()->create();

    livewire(Pages\EditInvoice::class, [
        'record' => $invoice->getKey()
    ])
    ->fillForm($this->invoice->toArray())
    ->call('save')
    ->assertHasNoFormErrors();

    expect($invoice->refresh())
        ->project->toBe($this->invoice->project)
        ->status->toBe($this->invoice->status)
        ->amount->toBe($this->invoice->amount)
        ->description->toBe($this->invoice->description);
});

it('can delete', function() {
    $invoice = Invoice::factory()->create();

    livewire(Pages\EditInvoice::class, [
        'record' => $invoice->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($invoice);
});
