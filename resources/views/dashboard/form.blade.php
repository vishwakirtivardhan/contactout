@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }} 
                    <span class="text-danger">| Referral Count : {{ Auth::user()->referral_count==null ?'0':Auth::user()->referral_count }} </span>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                    {{ $message }}
                    </div>
                    @endif
                    @if ($message = Session::get('inserterror'))
                    <div class="alert alert-danger" role="alert">
                    {{ $message }}
                    </div>
                    @endif
                    
                    @if($fieldCount > 0)
                    You can enter upto {{ $fieldCount }} emails.
                    <form action="submitForm" method="post">
                        @csrf
                        <div class="form-group">
                          <br>
                            <!-- Input Email Box -->
                            <label for="exampleInputEmail1">Email your invitation</label>
                            <select class="form-control" name="referralEmail[]" multiple="multiple">
                            </select>
                         </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @else
                    <div class="alert alert-danger" role="alert">
                    your referral limit exceeded.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
      
</div>
@if(!empty($data))

<div class="container pt-5">
    <div class="row justify-content-center">
    
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ __('Your Referrals') }}</div>
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>Email Referred</th>
                            <th>Referral Email Sent</th>
                            <th>User Login </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $res)   
                    <tr>
                            <td>{{$res['refferal_email']}}</td>
                            <td><?php echo $res['send_status']==1?'Yes':'No'; ?></td>
                            <td><?php echo $res['profile_created']==1?'Yes':'No'; ?></td>
                            <td>{{ date('Y-m-d h:i:s', strtotime($res['created_at'])); }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif


<script>
  // Check on enter emails in Inputbox. 
var dataRes = 'Enter Valid Email';
$('select').select2({

    tags: true,
    minimumInputLength: 4,
    placeholder:'email@mail.com , mail@email.com',
    maximumSelectionLength: {{$fieldCount;}},
    tokenSeparators: [',', ' '],

    createTag: function(params) {

        var email = params.term;
        // Don't offset to create a tag if there is no @ symbol
        if (email.indexOf('@') === -1) {
            return null;
        } else {
            // Js Email Validation
            var emailvalidate = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            var validEmail = emailvalidate.test(email);
            // console.log(validEmail);
            if (validEmail != false) {
              // Ajax for checking email id vaild and exists or not.
                $.ajax({
                    type: "POST",
                    url: base_url + "validateEmail",
                    async: false,
                    data: {
                        'email': email,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        dataRes = JSON.parse(data);
                    }
                })
                // console.log(dataRes);
                if (dataRes.status == 700) {
                    // console.log('checks');
                    return null;
                }

            }else {
                return null;
            }
        }

        return {
            id: params.term,
            text: params.term
        }
    },
    "language": { 
        "noResults": function() {
            try {
                if (dataRes.status !== 200) {
                    return dataRes.msg;
                }
            } catch (e) {
                return 'Enter Valid email Address';
            }
            return 'Enter Valid Email';
        }
    }

});

</script>

@endsection