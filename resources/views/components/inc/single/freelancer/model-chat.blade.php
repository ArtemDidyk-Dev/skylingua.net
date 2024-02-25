<div class="modal" id="chat">
    <div class="modal-dialog modal-dialog-centered modal-lg container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="contacts-form-title h3">
                    {{ language('Chat Now') }}
                </div>
                <span class="modal-close chat">
                    <img width="25" height="25" src="/images/close.png" alt="close">
                </span>
            </div>
            <div class="modal-body">
                <div class="modal-info">
                    <form action="{{ $link }}"
                        method="POST">
                        @csrf
                        <div class="feedback-form">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="hidden" name="freelancer_id" value="{{ $id }}">
                                    <x-inc.inputs.input label="{{ language('Your Name') }}">
                                        <x-inc.inputs.text name="name" type="text" value="{{ old('name', Auth::user()->name ?? null) }}"
                                            placeholder="{{ language('Your Name') }}" required="required"
                                            />
                                    </x-inc.inputs.input>
                                    @error('name')
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <x-inc.inputs.input label="{{ language('Your E-mail') }}">
                                        <x-inc.inputs.text name="email" type="text" value="{{ old('email', Auth::user()->email ?? null) }}"
                                            placeholder="{{ language('Your E-mail') }}" required="required"
                                            />
                                    </x-inc.inputs.input>
                                    @error('email')
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group">
                                    <x-inc.inputs.input label="{{ language('Order notes (optional)') }}">
                                        <x-inc.inputs.textarea value="{{ old('letter') }}"
                                            placeholder="{{ language('Notes about your order') }}" name="letter" />
                                    </x-inc.inputs.input>
                                    @error('letter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 submit-section">
                                <label class="custom_check">
                                    <input name="agree" type="checkbox" name="select_time" required="required"
                                        autocomplete="OFF"
                                        @if (old('agree')) checked="checked" @endif>
                                    <span class="checkmark"></span> {{ language('I agree to the') }} <a
                                        href="/page/terms-conditions"
                                        target="_blank">{{ language('Terms And Conditions') }}</a>
                                </label>
                                @error('agree')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 submit-section text-end">
                                <x-inc.btns.filter color="black" title="{{ language('GO TO CHAT') }}" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>