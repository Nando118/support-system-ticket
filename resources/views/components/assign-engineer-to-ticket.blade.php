<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    <div class="btn-group">
        <a href="{{ route("ticket.reply.index", ["id" => $id]) }}" class="btn btn-primary btn-sm" title="View"><i class="fa-regular fa-comments"></i><p style="position: absolute; top: -5px; right: -5px; z-index: 50" class="text-bold badge badge-danger d-flex">99</p></a>
        @can("assign-ticket")
            <button type="button" class="btn btn-info btn-sm" title="Assign Engineer" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"><i class="fa-solid fa-user"></i></button>
        @endcan
        <button type="button" class="btn btn-success btn-sm" title="Done"><i class="fa-solid fa-check"></i></button>
    </div>
</div>

<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Engineer<span style="color: red;">*</span></label>
                            <select class="form-control custom-select" id="exampleFormControlSelect2" name="engineer">
                                <option value="" selected disabled>Choose here...</option>
                                @foreach($engineers as $engineer)
                                    <option value="{{ $engineer->id }}">
                                        {{ $engineer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </div>
    </div>
</div>
