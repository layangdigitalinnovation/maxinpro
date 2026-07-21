<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use App\Support\IndonesianPhone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_normalizes_leading_zero_to_country_code(): void
    {
        $this->assertSame('6281234567890', IndonesianPhone::toWhatsappFormat('081234567890'));
    }

    public function test_handles_numbers_with_spaces_dashes_and_plus(): void
    {
        $this->assertSame('6281234567890', IndonesianPhone::toWhatsappFormat('+62 812-3456-7890'));
        $this->assertSame('6281234567890', IndonesianPhone::toWhatsappFormat('0812 3456 7890'));
    }

    public function test_already_correct_format_is_left_alone(): void
    {
        $this->assertSame('6281234567890', IndonesianPhone::toWhatsappFormat('6281234567890'));
    }

    public function test_wa_link_contains_normalized_number_and_encoded_message(): void
    {
        $link = IndonesianPhone::waLink('081234567890', 'Halo, ini tes');

        $this->assertStringContainsString('https://wa.me/6281234567890', $link);
        $this->assertStringContainsString('text=', $link);
        $this->assertStringContainsString(urlencode('Halo, ini tes'), $link);
    }

    public function test_lead_wa_link_uses_lead_own_phone_not_business_number(): void
    {
        $lead = Lead::factory()->create(['phone' => '081298765432', 'name' => 'Budi']);

        $this->assertStringContainsString('6281298765432', $lead->waLink());
        $this->assertStringContainsString('Budi', urldecode($lead->waLink()));
    }

    public function test_wa_chat_button_appears_on_admin_leads_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Lead::factory()->create(['phone' => '081234567890']);

        $response = $this->actingAs($admin)->get(route('admin.leads.index'));

        $response->assertOk();
        $response->assertSee('wa.me/6281234567890', false);
    }
}
