 <!-- Modal -->
<div class="modal fade" id="modal_branch_offices" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <form method="GET" action="" accept-charset="UTF-8" class="">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sucursales</h4>
        </div>
        <div class="modal-body form-horizontal">
          <div class="form-group">
              <div class="col-sm-12">
                @if (session('branch_offices'))
                   {!! Form::select("branch_office_id", session("branch_offices"), "", ["class" => "form-control"]) !!}
                @endif
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" type="submit">Seleccionar</button>
        </div>
    </div>
    </form>
</div>
</div>
<!-- modal -->
