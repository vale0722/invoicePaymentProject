<?php

namespace Tests\Feature\Invoice;

use App\Client;
use App\Seller;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function theHomeViewIsTheInvoiceIndexView()
    {
        $this->get(route('home'))->assertViewIs('invoices.index');
    }

    /**
     * @test
     */
    public function atHomeYouCanSeeTheInvoicesList()
    {
        factory(Invoice::class, 5)->create();
        $this->get(route('home'))->assertViewHas('invoices');
    }
}
