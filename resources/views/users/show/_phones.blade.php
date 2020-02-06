<?php
use App\Models\Users\User;
use App\Models\Users\Phone;
/**
 * @var User $user
 */
?>
@if (isset($user))

    @forelse($user->getPhones() as $phone)
        @include('form._input',[
   'name'=>'phones[]',
   'type'=>'tel',
   'label'=>'Телефон',
   'value'=>$phone->getName(),
])
        @empty
        @include('form._input',[
   'name'=>'phones[]',
   'type'=>'tel',
   'label'=>'Телефон',
])
        @endforelse
@else
    @include('form._input',[
    'name'=>'phones[]',
    'type'=>'tel',
    'label'=>'Телефон',
])
    @endif


<button type="button" class="btn btn-outline-secondary btn-block" id="copy_tel">
    Добавить телефон <i class="fa fa-fw fa-plus"></i>
</button>


@push('scripts')
<script>
    $('#copy_tel').on('click',function () {
        let
            telSelector = '[type=tel]',
            telInputs = $(telSelector),
            telInput = telInputs.filter(':last')

        let telGroup = telInput.closest('.form-group'),
            telGroupClone = telGroup.clone();

        if (telInputs.length < 5){
            telGroupClone.filter('[type=tel]').val('');
            telGroup.after(telGroupClone);
            $(telSelector).filter(':last').val('');
            appPhoneMask.init();
        }else{
            alert('Нельзя добавить больше пяти номеров телефона')
        }
    })
</script>

    @endpush
