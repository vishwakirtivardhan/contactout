@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
    
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ __('Admin Dashboard - Referrals') }}</div>
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>Referrer</th>
                            <th>Email Referred</th>
                            <th>Email-Trigger</th>
                            <th>Status </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $res)   
                    <tr>
                            <td>{{$res->sender_name}}</td>
                            <td>{{$res->refferal_email}}</td>
                            <td><?php echo $res->send_status==1?'Yes':'No'; ?></td>
                            <td><?php echo $res->profile_created==1?'Yes':'No'; ?></td>
                            <td>{{$res->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection