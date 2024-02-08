@if (\App\Services\CommonService::userRoleId(auth()->id()) == 3)
    <div class="modal" id="proposal">
        <div class="modal-dialog modal-dialog-centered modal-lg container">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="contacts-form-title h3">
                        {{ language('SEND PROPOSALS') }}
                    </div>
                    <span class="modal-close">
                        <img width="25" height="25" src="/images/close.png" alt="close">
                    </span>
                </div>
                <div class="modal-body">
                    <div class="modal-info">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin: 0 0 0 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('frontend.pay.go') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="freelancer_id" value="{{ $id }}">
                            <div class="feedback-form">
                                <div class="row">
                                    @if ($projectslist)
                                    <div class="col-md-12 form-group">
                                        <label for="price">{{ language('Your Projects') }}</label>
                                        <select class="form-control select" name="project_id" id="project_id">
                                            @foreach ($projectslist as $project)
                                                <option value="{{ $project->id }}"
                                                    @if (old('project_id') == $project->id) selected @endif>
                                                    {{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>     
                                    @endif
                                   
                                    <div class="col-md-6 form-group">
                                        <x-inc.inputs.input label="{{ language('Your Price') }}">
                                            <x-inc.inputs.text name="price" type="number" value="{{ old('price') }}"
                                                placeholder="{{ language('Your Price') }}" required="required"
                                                step="0.01" min="0" />

                                        </x-inc.inputs.input>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <x-inc.inputs.input label="{{ language('Estimated Days') }}">
                                            <x-inc.inputs.text name="hours" type="number"
                                                value="{{ old('hours') }}"
                                                placeholder="{{ language('Example: 11 Days') }}" required="required"
                                                step="1" min="0" />
                                        </x-inc.inputs.input>
                                        @error('hours')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <x-inc.inputs.input label="Message">
                                            <x-inc.inputs.textarea value="{{ old('letter') }}"
                                                placeholder="{{ language('Cover Letter') }}" name="letter" />
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
                                    <x-inc.btns.filter color="black" title="{{ language('SUBMIT PROPOSAL') }}" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

