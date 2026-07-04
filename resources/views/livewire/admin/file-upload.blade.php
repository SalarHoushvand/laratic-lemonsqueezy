@push('head')
    <title>{{ __('Upload File') }}</title>
@endpush
<div class="flex flex-col gap-6">
    <x-typography.admin-page-header :title="__('Upload File')" :description="__('Upload files to AWS S3 and get a shareable URL instantly.')" />

    <div class="flex flex-col gap-6 lg:grid lg:grid-cols-12">
        {{-- Main Upload Area --}}
        <div class="col-span-12 lg:col-span-8">
            <div class="panel">
                <div class="flex items-center gap-3 mb-6">
                    <x-icons.cloud-arrow-up variant="outline" size="lg" class="text-primary dark:text-primary-dark" />
                    <div>
                        <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ __('Upload File') }}
                        </h2>
                        <p class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted mt-1">
                            {{ __('Select a file to upload to S3') }}
                        </p>
                    </div>
                </div>

                <x-input-file
                    wire:model="uploadedFile"
                    label="{{ __('Choose a file to upload') }}"
                />

                @if ($fileUrl)
                    <div class="mt-6 pt-6 border-t border-outline dark:border-outline-dark">
                        <div class="flex items-start gap-3 mb-4">
                            <x-icons.check-circle variant="solid" size="md" class="text-success shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                    {{ __('Upload Successful') }}
                                </h3>
                                <p class="text-xs text-on-surface-muted dark:text-on-surface-dark-muted mt-1">
                                    {{ __('Your file has been uploaded successfully. Copy the URL below to use it anywhere.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($fileUrl)
                <div class="flex flex-col gap-6 mt-6">
                    <div class="panel"
                        x-data="{
                            copiedToClipboard: false,
                            copyUrl() {
                                navigator.clipboard.writeText(@js($fileUrl)).then(() => {
                                    this.copiedToClipboard = true;
                                    setTimeout(() => {
                                        this.copiedToClipboard = false;
                                    }, 2000);
                                });
                            }
                        }">
                        <div class="flex items-center gap-3 mb-4">
                            <x-icons.link variant="outline" size="md" class="text-primary dark:text-primary-dark" />
                            <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ __('File URL') }}
                            </h2>
                        </div>

                        <div class="flex gap-2">
                            <input
                                type="text"
                                value="{{ $fileUrl }}"
                                readonly
                                class="flex-1 bg-surface-alt border border-outline rounded-radius px-3 py-2 text-sm text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark"
                            />
                            <button
                                type="button"
                                x-on:click="copyUrl()"
                                class="flex items-center gap-2 rounded-radius px-4 py-2 text-sm font-medium text-on-surface bg-surface-alt border border-outline hover:bg-surface-dark/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface/10 dark:focus-visible:outline-primary-dark"
                            >
                                <x-icons.clipboard x-cloak x-show="!copiedToClipboard" variant="outline" size="sm" />
                                <x-icons.clipboard-document-check x-cloak x-show="copiedToClipboard" variant="solid" size="sm" class="fill-success" />
                                <span x-text="copiedToClipboard ? '{{ __('Copied!') }}' : '{{ __('Copy') }}'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Image Preview --}}
                    @if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $fileUrl))
                        <div class="panel">
                            <div class="flex items-center gap-3 mb-4">
                                <x-icons.photo variant="outline" size="md" class="text-primary dark:text-primary-dark" />
                                <h2 class="heading-5 text-on-surface-strong dark:text-on-surface-dark-strong">
                                    {{ __('Preview') }}
                                </h2>
                            </div>
                            <div class="rounded-radius border border-outline dark:border-outline-dark bg-surface-alt dark:bg-surface-dark-alt p-4">
                                <div x-data="{ err: false }" class="flex items-center justify-center">
                                    <img
                                        x-show="!err"
                                        x-on:error="err = true"
                                        src="{{ $fileUrl }}"
                                        alt="{{ __('Uploaded image preview') }}"
                                        class="max-w-full h-auto max-h-96 rounded-radius object-contain"
                                    />
                                    <div x-show="err" class="text-sm text-on-surface-muted dark:text-on-surface-dark-muted text-center py-8">
                                        <x-icons.exclamation-circle variant="outline" size="lg" class="mx-auto mb-2 text-warning" />
                                        <p>{{ __('Could not load image preview') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Sidebar Information --}}
        <div class="col-span-12 lg:col-span-4">
            <div class="lg:sticky lg:top-6 space-y-6">
                <div class="panel">
                    <div class="flex items-center gap-3 mb-4">
                        <x-icons.information-circle variant="outline" size="md" class="text-primary dark:text-primary-dark" />
                        <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ __('About File Uploads') }}
                        </h3>
                    </div>
                    <div class="space-y-3 text-sm text-on-surface dark:text-on-surface-dark">
                        <p>
                            {{ __('Files are uploaded to AWS S3, a reliable cloud storage service.') }}
                        </p>
                        <div>
                            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong mb-2">
                                {{ __('Supported File Types:') }}
                            </p>
                            <ul class="list-disc pl-5 space-y-1 text-on-surface-muted dark:text-on-surface-dark-muted">
                                <li>{{ __('Images (JPG, PNG, GIF, WebP)') }}</li>
                                <li>{{ __('Videos (MP4, MOV, AVI)') }}</li>
                                <li>{{ __('Audio (MP3, WAV, OGG)') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="flex items-center gap-3 mb-4">
                        <x-icons.light-bulb variant="outline" size="md" class="text-primary dark:text-primary-dark" />
                        <h3 class="heading-6 text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ __('Tips') }}
                        </h3>
                    </div>
                    <ul class="space-y-2 text-sm text-on-surface dark:text-on-surface-dark">
                        <li class="flex items-start gap-2">
                            <x-icons.check variant="mini" size="sm" class="text-success shrink-0 mt-0.5" />
                            <span>{{ __('Copy the URL to use in your content, posts, or anywhere else.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check variant="mini" size="sm" class="text-success shrink-0 mt-0.5" />
                            <span>{{ __('Image files will show a preview automatically.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check variant="mini" size="sm" class="text-success shrink-0 mt-0.5" />
                            <span>{{ __('URLs are permanent and can be shared publicly.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

