<!-- modal -->
<div class="modal-content">
    <div class="modal-header">
        <div class="modal-title">
            <h5>Ads Log</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr align="center">
                <th scope="col">#</th>
                <th scope="col">Log Action</th>
                <th scope="col">Log Description</th>
                <th scope="col">Log Created</th>
                <th scope="col">Admin</th>

            </tr>
            </thead>
            <tbody>

            @foreach($ads as $ad_log)

                <tr align="center">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td> {{$ad_log->ads_log_action}}</td>
                    <td>{{$ad_log->ads_log_description}}</td>
                    <td>{{$ad_log->ads_log_created}}</td>
                    <td>{{$ad_log->user->user_fullname ?? '-'}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
