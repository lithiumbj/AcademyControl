@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\User;
use App\Models\Chat;
?>
<section class="content-header">
  <h1>
    Chat
    <small>Mensajería interna</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Clientes</a></li>
    <li class="active">Listado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-warning direct-chat direct-chat-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Usuarios</h3>
            <div class="box-tools pull-right">
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
              <table class="table table-bordered ">
                  <tbody>
                      @foreach($users as $user)
                      <tr>
                          <td style="cursor:pointer;" onclick="loadMessages({{$user->id}})">
                              {{$user->name}} 
                              @if(Chat::getMessageCountForUser($user->id)>0)
                                <small class="label pull-right bg-green">{{Chat::getMessageCountForUser($user->id)}}</small>
                              @endif
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
        </div>
      </div>
        
        <div class="col-md-8">
        <!-- DIRECT CHAT -->
        <div class="box box-warning direct-chat direct-chat-warning">
          <div class="box-header with-border">
            <h3 class="box-title"> Mensajes del usuario</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages" id="chatContainer">
                              

            </div><!--/.direct-chat-messages-->

          </div><!-- /.box-body -->
          <div class="box-footer">
              <div class="input-group">
                <input type="text" name="message" id="messageTxt" placeholder="Escribir ..." class="form-control">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-warning btn-flat" onclick="sendMessage()"><i class="fa fa-envelope-o"></i></button>
                </span>
              </div>
          </div><!-- /.box-footer-->
        </div><!--/.direct-chat -->
      </div>
    </div>
</section>

<script>
    var userId;
    var serviceEnabled = false;
    /*
     * This function downloads the messages for a user
     */
    function loadMessages(fk_user)
    {
        userId = fk_user;
        jQuery.ajax({
            url: "{{URL::to('/chat/getMessages')}}",
            method: "POST",
            data : {_token : "{{csrf_token()}}", fk_user: fk_user}
          }).done(function(data) {
                var jsonData = JSON.parse(data);
                //Clean the GUI
                jQuery("#chatContainer").html("");
                //Load the messages
                for(var i=0; i<jsonData.messages.length; i++){
                    if(jsonData.messages[i].fk_sender != {{\Auth::user()->id}})
                        jQuery("#chatContainer").append('<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right"></span><span class="direct-chat-timestamp pull-left">'+jsonData.messages[i].created_at+'</span></div><img class="direct-chat-img" src="{{URL::to("/images/")}}/'+jsonData.messages[i].fk_sender+'.png" alt="message user image"><div class="direct-chat-text">'+jsonData.messages[i].body+'</div></div>');
                    else
                        jQuery("#chatContainer").append('<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left"></span><span class="direct-chat-timestamp pull-right">'+jsonData.messages[i].created_at+'</span></div><img class="direct-chat-img" src="{{URL::to("/images/")}}/'+jsonData.messages[i].fk_sender+'.png" alt="message user image"><div class="direct-chat-text">'+jsonData.messages[i].body+'</div></div>');
                }
                //After load messages, scroll to down
                $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
                //And start the reload/refresh messages service
                if(!serviceEnabled)
                reloadService();
          }).fail(function(){
              //Do some more visual and less intrusive
          });
    }
    /*
     * Send's the message to the server
     */
    function sendMessage()
    {
        var message = jQuery("#messageTxt").val();
        jQuery.ajax({
            url: "{{URL::to('/chat/sendMessage')}}",
            method: "POST",
            data : {_token : "{{csrf_token()}}", fk_sender: {{\Auth::user()->id}}, fk_receiver: userId, message: jQuery("#messageTxt").val()}
          }).done(function(data) {
                if(data == 'ok'){
                    loadMessages(userId);
                    jQuery("#messageTxt").val("");
                }else{
                   alert("Desafortunadamente, ocurrió un error al mandar el mensaje");
                }
          }).fail(function(){
              alert("Ocurrió un error al cargar el chat");
          });
    }
    
    function reloadService()
    {
        //Set the service to on
        serviceEnabled = true;
        //Start the service
        window.setInterval(function(){
            loadMessages(userId);
        }, 4000);
        //Return key listener
        $("#messageTxt").keyup(function (e) {
            if (e.keyCode == 13) {
                sendMessage();
                return false;
            }
        });
    }
</script>
    @stop