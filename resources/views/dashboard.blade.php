@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-subscribers-tab" data-toggle="pill" href="#pills-subscribers" role="tab" aria-controls="pills-subscribers" aria-selected="true">Subscribers</a>
                      </li>

                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab" aria-controls="pills-group" aria-selected="false">Groups</a>
                      </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                      
                      <div class="tab-pane fade show active" id="pills-subscribers" role="tabpanel" aria-labelledby="pills-subscribers-tab">
                          <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width: 100%;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Last Active</th>
                                            <th>Joined</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            {{ $num = 1; }}
                                        @endphp
                                        @foreach ($subscribers as $subscriber)
                                            <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $subscriber->subscriber_id }}</td>
                                                <td>{{ $subscriber->name }}</td>
                                                <td>{{ $subscriber->username }}</td>
                                                <td>
                                                    {{
                                                        \Carbon\Carbon::parse($subscriber->last_active)->diffForHumans() 
                                                     }}
                                                 </td>
                                                <td>
                                                    {{
                                                        \Carbon\Carbon::parse($subscriber->created_at)->diffForHumans() 
                                                     }}
                                                 </td>
                                                 <td>
                                                     <button class="btn btn-primary btn-sm"
                                                     data-toggle="modal" data-target="#sendModal" data-send-id="{{ $subscriber
                                                        ->subscriber_id }}"
                                                     data-title="{{ $subscriber->username }}"
                                                     >
                                                         Send
                                                     </button>
                                                 </td>
                                            </tr>
                                            @php
                                                {{ $num++; }}
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                      </div>

                      <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                          <div class="table-responsive">
                                <table id="example2" class="table table-striped table-bordered" style="width: 100%;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Last Active</th>
                                            <th>Joined</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            {{ $num = 1; }}
                                        @endphp
                                        @foreach ($subscriberGroups as $subscriberGroup)
                                            <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $subscriberGroup->group_id }}</td>
                                                <td>{{ $subscriberGroup->title }}</td>
                                                <td>{{ $subscriberGroup->type }}</td>
                                                <td>
                                                    {{
                                                        \Carbon\Carbon::parse($subscriberGroup->last_active)->diffForHumans() 
                                                     }}
                                                 </td>
                                                <td>
                                                    {{
                                                        \Carbon\Carbon::parse($subscriberGroup->created_at)->diffForHumans() 
                                                     }}
                                                 </td>
                                                 <td>
                                                     <button class="btn btn-primary btn-sm"
                                                     data-toggle="modal" data-target="#sendModal" data-send-id="{{ 
                                                        $subscriberGroup
                                                        ->group_id }}"
                                                     data-title="
                                                        {{ $subscriberGroup
                                                            ->title }}">
                                                         Send
                                                     </button>
                                                 </td>
                                            </tr>
                                            @php
                                                {{ $num++; }}
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                      </div>
                    </div>
                    
                    <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="sendModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="" method="POST">
                                @csrf
                              <div class="form-group">
                                <label for="conversation" class="col-form-label">Select Conversation</label>
                                <select name="conversation" id="conversation" class="custom-select">
                                    <option>Select Conversion</option>
                                    <option value="random">Random</option>
                                    <option value="breed">Breed</option>
                                    <option value="sub-breed">Sub Breed</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="message" class="col-form-label">Message</label>
                                <textarea class="form-control" name="message" id="message" cols="20" rows="10"></textarea>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Send message</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="card-footer">
                  <small><a href="{{ url('storage/logs/chatslog.log') }}">Download Log File </a></small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
jQuery.noConflict();
(function($) {
  $(function() {
   $('table.table-striped').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ],
        "order": [[ 4, 'asc' ]]
    });
    $('#sendModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var id = button.data('send-id')
      var title = button.data('title')

      if (title === '') {
        title = id
      }
      
      var modal = $(this)
      modal.find('form')[0].action = '/send/' + id
      modal.find('.modal-title').text('New Conversation to ' + title)
      modal.find('.modal-body #title').val(title)
    })
  });
})(jQuery);
</script>
@endsection
