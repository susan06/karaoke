<!--edit or create Modal-->
<div class="modal fade" id="general-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background: #fff;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title"></h4>
      </div>
      <div id="content-modal">
        <!--content load -->
      </div>
    </div>
  </div>
</div>
<!-- /.modal --> 

<!--login Modal-->
<div class="modal fade" id="modal_login" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #fff; max-width: 350px;margin-left: auto; margin-right: auto;">
      <!--
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title">Validar credenciales</h4>
      </di>
      -->
      <div class="login-form" id="login-form" style="margin: 0px auto 0px auto;">
         <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt blue"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.email_or_username')" value="" autofocus>
            </div>
            <div class="input-group">
                <input type="tel" name="pin-1" id="pin-1" maxlength="1" pattern="[0-9]" data-order="1" class="input-pin input-first" autocomplete="off">
                <input type="tel" name="pin-2" id="pin-2" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="2" class="input-pin" autocomplete="off">
                <input type="tel" name="pin-3" id="pin-3" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="3" class="input-pin" autocomplete="off">
                <input type="tel" name="pin-4" id="pin-4" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="4" class="input-pin input-last" autocomplete="off">
            </div>
            <buttom class="btn btn-primary btn-lg btn-block btn-pin-login disabled">Validar mis credenciales</buttom>
        </div>
      </div>
    </div>
  </div>
</div>

<!--login Modal-->
<div class="modal fade" id="modal_login_nick" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #fff; max-width: 350px;margin-left: auto; margin-right: auto;">
      <div class="login-form" id="login-form-nick" style="margin: 0px auto 0px auto;">
         <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt blue"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="nick" id="nick" class="form-control" placeholder="@lang('app.name')" value="" autofocus>
            </div>
            <buttom class="btn btn-primary btn-lg btn-block btn-pin-login-nick">Guardar canción a mi nombre</buttom>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.modal --> 