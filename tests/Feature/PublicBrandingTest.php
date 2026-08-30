<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicBrandingTest extends TestCase
{
    public function test_storefront_homepage_has_no_bagisto_text(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $content = $response->getContent();

        // 1. Must NOT contain Bagisto in visible text, meta tags, or placeholders
        $this->assertStringNotContainsString('Loading categories from Bagisto', $content);
        $this->assertStringNotContainsString('<meta name="generator" content="Bagisto"', $content);

        // 2. Must contain Kawaii Blessings and KeynoStore
        $this->assertStringContainsString('Kawaii Blessings', $content);
        $this->assertStringContainsString('KeynoStore', $content);
    }

    public function test_llms_text_files_are_branded(): void
    {
        $llms = file_get_contents(public_path('llms.txt'));
        $this->assertStringContainsString('Kawaii Blessings', $llms);
        $this->assertStringContainsString('KeynoStore', $llms);
        $this->assertStringNotContainsString('Bagisto Developer', $llms);

        $llmsFull = file_get_contents(public_path('llms-full.txt'));
        $this->assertStringContainsString('Kawaii Blessings', $llmsFull);
        $this->assertStringContainsString('KeynoStore', $llmsFull);
        $this->assertStringNotContainsString('# Bagisto Developer Documentation', $llmsFull);
    }
}
