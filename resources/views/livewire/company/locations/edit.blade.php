<div class="container-fluid">
    <div class="page-header  my-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">
                @if($name)
                            {{$name}} @else Geen naam @endif</h1>
     
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary btn-sm  btn-120" wire:click="save()">
                    Opslaan
                </button>
                <button type="button" onclick="history.back()" class="btn btn-secondary btn-sm  ">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">


     
                     <label>Afbeelding</label>
                    <br>        <br>
                    <div class="clear-fix"></div>
                    <span id="passwordHelpInline" class="form-text pt-4"> </span>
                    <div class="d-flex align-items-center">
                     <label class="avatar avatar-xxl   avatar-uploader   " for="editAvatarUploaderModal">
                            
                           @if ($image_db || $image )
                         <img class="avatar-img" src="{{ $image ? $image->temporaryUrl() :  url('/storage/'.$image_db)  }}" width="250" height="300" />
                         @else
                         <img class="avatar-img" src="/assets/img/160x160/img2.jpg"   />
                         @endif
                  
                         <input
                             type="file"
                             class="js-file-attach avatar-uploader-input"
                             id="editAvatarUploaderModal"
                             data-hs-file-attach-options='{
                                 "textTarget": "#editAvatarImgModal",
                                 "mode": "image",
                                 "targetAttr": "src",
                                 "allowTypes": [".png", ".jpeg", ".jpg"]
                              }'
                             wire:model.live="image"
                         />

                         <span class="avatar-uploader-trigger">
                             <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                         </span>
                     </label>

                      
                     <button   type="button" 
    wire:click="clearImage"
    wire:confirm.prompt="Hiermee verwijder je de afbeelding van deze locatie. Weet je zeker dat je deze actie wilt uitvoeren?\n\nType AKKOORD om te bevestigen|AKKOORD"    class="js-file-attach-reset-img btn btn-white  m-4">Verwijder</button>
                 </div>
                 <label class = "pb-2 pt-3">Gebouwtype</label>
                 <div wire:ignore class="tom-select-custom tom-select-custom-with-tags">
                    <select wire:model = "building_type_id" class="js-select form-select" autocomplete="off"  
                            data-hs-tom-select-options='{
                              "placeholder": "Selecteer een optie"
                            }'>

                            <option value=""></option>
                              @foreach(config('globalValues.building_types') as $key => $value)
                      <option 
                         value="{{ $key }}">
                         {{$value}}
                      </option>
                      @endforeach

                      @if($building_type_id)
                      <option @if($building_type_id) selected @endif value = "{{$building_type_id}}" >{{config('globalValues.building_types')[$building_type_id]}}</option>
@endif

                      
                    </select>
                  </div>



                  <label class = "pb-2 pt-3">Beheerder</label>
                  
                  <div    class="tom-select-custom  ">
                               <select wire:model.live = "management_id" class="js-select form-select" autocomplete="off"  
                                      data-hs-tom-select-options='{
                                        "placeholder": "Selecteer een optie"
                                      }'>
                           

                                      @foreach($managementCompanies as $managementCompany).

                                     
                                <option value="{{$managementCompany?->id}}">{{$managementCompany?->name}}</option>
                               
            @endforeach

            <option @if($management_id) selected @endif value = "{{$management_id}}" ></option>

                                 
                              </select>
                            </div>

                            <label class = "pb-2 pt-3">Complexnummer</label>
                              <input style = "width: 200px;" wire:model = "complexnumber"  class  = "form-control">
                      


                 
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header card-header-content-md-between  ">

                    Gebouw gegevens
                </div>

                <div class="card-body">
                    <div class = "row">
                        <div class = "col-md-12">
                           <div>
                              <label class = "pb-2">Naam</label>
                              <input wire:model = "name"  class  = "form-control    @error('name') is-invalid   @enderror  " >
                              @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                           </div>
                        </div>
                     </div>
                     <div class = "row">
                        <div class = "col-md-6">
                           <div class  = "pt-3" style = "width :300px;">
                              <label class = "pb-2">Postcode</label>
                              <div class="input-group   ">
                                 <input class="form-control required  @if ($errors->has('zipcode'))  is-invalid @endif " wire:model.defer="zipcode" style = "width: 200px;">
                                 <div class="input-group-append">
                                    <button class = "btn btn-soft-primary" style = "height: 43px" wire:click = "checkZipcode"  data-toggle="tooltip" data-placement="top" title="Zoek naar postcode" wire:keydown="checkZipcode" style = "height: 40px;">
                                    <i class="bi-search"></i>
                                    </button>
                                 </div>
                                 @if ($errors->has('zipcode')) <span class="text-danger">Postcode formaat niet juist</span> @endif
                              </div>
                           </div>
                           <div class  = "pt-3">
                              <label class = "pb-2">Plaats</label>
                              <input wire:model = "place"  class  = "form-control">
                           </div>
                        </div>
                        
                        <div class = "col-md-6">
                           <div class  = "pt-3">
                              <label class = "pb-2">Adres</label>
                              <input wire:model = "address"  class  = "form-control">
                           </div>


                         
                        </div>


                        
                     </div>
      
                <div class = "row">
                  <div class = "col-md-12">
        
                     <div class="d-flex justify-content-between">
                        <label class = "pb-2 pt-3">Notite</label>
    
                        <span id="maxLengthCountCharacters" class="text-muted mt-3"></span>
                    </div>
                    <textarea wire:model = "remark" class="js-count-characters form-control" wire:model="description" name="description" rows="4"
                        maxlength="100" data-hs-count-characters-options='{
            "output": "#maxLengthCountCharacters"
          }'>{{ old('name',@$project->description) }}</textarea>
                  </div>
                </div>
            </div>
        </div>

    </div>
</div>
 