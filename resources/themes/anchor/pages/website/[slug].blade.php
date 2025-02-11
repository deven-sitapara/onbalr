<?php
use function Livewire\Volt\{state, mount};
use App\Models\WebsitePages;

state(['html' => '', 'css' => '', 'currentPage' => null]);

mount(function ($slug = null) {
    if ($slug) {
        $this->currentPage = WebsitePages::firstOrCreate(['slug' => $slug]);
        $this->html = $this->currentPage->html ?? '';
        $this->css = $this->currentPage->css ?? '';
    }
});

$savePage = function () {
    $this->currentPage->update([
        'html' => $this->html,
        'css' => $this->css,
    ]);

    $this->dispatch('page-saved');
};
?>

<x-layouts.website>
    <x-app.container x-data class="lg:space-y-6" x-cloak>
        <x-app.heading title="{{ $page->title ?? 'New Page' }}" description="" :border="false" />

        <div>
            <div id="gjs" style="height: 600px; border: 1px solid #ddd;">
                {!! $html !!}
            </div>

            <div class="mt-4">
                <button wire:click="savePage" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Save Page
                </button>
            </div>

            <style>
                {!! $css !!}
            </style>

            @script
                <script>
                    const editor = grapesjs.init({
                        container: '#gjs',
                        plugins: ['gjs-blocks-basic'],
                        storageManager: false,
                        panels: {
                            defaults: [
                                // Default panels
                            ]
                        },
                        blockManager: {
                            blocks: [{
                                    id: 'section',
                                    label: 'Section',
                                    category: 'Basic',
                                    content: `
                                        <section class="h-48 bg-gray-100 flex items-center justify-center">
                                            <h2>Section Content</h2>
                                        </section>
                                    `
                                },
                                {
                                    id: 'hero',
                                    label: 'Hero',
                                    category: 'Sections',
                                    content: `
                                        <div class="py-20 bg-blue-600 text-white">
                                            <div class="container mx-auto px-6">
                                                <h1 class="text-5xl font-bold">Hero Title</h1>
                                                <p class="mt-4 text-xl">Hero description goes here</p>
                                            </div>
                                        </div>
                                    `
                                }
                            ]
                        }
                    });

                    // Save content to Livewire state
                    editor.on('change:changesCount', () => {
                        @this.html = editor.getHtml();
                        @this.css = editor.getCss();
                    });
                </script>
            @endscript
        </div>
    </x-app.container>
</x-layouts.website>
