@if(!empty($data['status']))
    @if($data['status'] == 'Success')
        <div class="alert alert-success d-flex justify-content-between" role="alert">
            <span>
                <i class="fa fa-check-circle-o fs-4 pe-2" aria-hidden="true"></i>{{ $data['info'] }}
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif($data['status'] == 'Failed' or $errors->any())
        <div class="alert alert-danger d-flex justify-content-between" role="alert">
            <span>
                <i class="fa fa-exclamation-circle fs-4 pe-2" aria-hidden="true"></i>{{ $data['info'] ?? 'Encryption failed' }} 
            </span>
            
            <button type="button" class="btn-close align-self-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endif