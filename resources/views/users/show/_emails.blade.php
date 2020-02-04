
@include('form._input',[
    'name'=>'emails[]',
    'type'=>'email',
    'label'=>'Email',
    'disabled'=>true,
])

<button type="button" class="btn btn-outline-secondary btn-block">
    Добавить электронную почту <i class="fa fa-fw fa-plus"></i>
</button>
