{* Main Calendar Component *}
<script type="text/x-template" id="calendar-component">
  <div>
    <table class="appointment-table" id="appointment_table">
      <thead>
        <tr>
          <td v-for="(day, key) in bookings_days"><% moment(key).format('DD.MM.YYYY') %><br> <small><% moment(key).format('dddd') %></small></td>
        </tr>
      </thead>
      <tbody mouseleave="unsetHover()">
        <tr>
          <calendar-day v-for="(bookings, key, index) in bookings_days" v-model="selectedBookingStart"
            :key="key"
            :date="key"
            :bookings="bookings"
            :index="index"
            :cells="cells_count"
            :active="key == active.day ? active.cells : []"
            :hover="key == hover.day ? hover.cells : []"></calendar-day>
        </tr>
      </tbody>
    </table>
    <div class="day">
      <div class="half-hour"></div>
    </div>

    <button type="button" class="button button-primary float-right m-t-sm" @click="createBooking" v-if="!this.$parent.is_admin">{'OP_BOOKING_SUBMIT'|tr}</button>
  </div>
</script>

{* Calendar Day component *}
<script type="text/x-template" id="calendar-day-component">
  <td>
    <calendar-cell v-for="(cell, cellIndex) in cells" 
      :key="cellIndex" 
      :cell="cell" 
      :index="cellIndex" 
      :show_times="index == 0" 
      :show_last_time="cell == cells"
      :active="active.includes(cell)"
      :hover="hover.includes(cell)"
      :appointment-id="bookingsCells[cell]"></calendar-cell>
  </td>
</script>

{* Calendar Cell component *}
<script type="text/x-template" id="calendar-cell-component">
  <div
    :class="{
      'time-box': true,
      'occupied': occupied,
      'selected': active,
      'hover-time-range': hover,
      'not-allowed': !allowed,
      'appointment-cell': (this.$parent.$parent.$parent.is_admin && appointmentId),
      'appointment-cell-dark': (this.$parent.$parent.$parent.is_admin && this.$parent.appointmentDarkColor.includes(appointmentId))
     }" @click.self="clickEvent" @mouseenter="hoverSendToParent">
    
    <div class="time-box-popup" v-if="appointmentId && this.$parent.$parent.$parent.is_admin && appointmentVisible">
      <span class="close-button" @click="triggerPopUp"></span>
      <div class="time-box-popup-heading"><strong><% appointment.customer.name %></strong></div>
      <p>
        <% appointment.name %> <br>
        <small class="time-box-popup-muted"><% moment(appointment.starts_at).format('DD.MM.YYYY HH:mm') %> - <% moment(appointment.starts_at).add(getTimeInMinutes(appointment.duration), 'minutes').format('HH:mm') %></small> <br>
      </p>
      <a :href="appointmentLink ? appointmentLink : ''" class="button-primary">Edit Appointment</a>
    </div>

    <small class="time-box-short-info" v-if="appointmentId && this.$parent.$parent.$parent.is_admin" @click="clickEvent">
      <% appointment.customer.name %> - <% appointment.name %>
    </small>

    <span v-if="show_times" class="time-info"><% getCellTime() %></span>
    <span v-if="show_times && show_last_time" class="time-info last"><% getCellTime(true) %></span>
  </div>
</script>

{* Services help component *}
<script type="text/x-template" id="services-help-component">
  <div class="service-help-wrap">
  </div>
</script>

{* Contact list component *}
<script type="text/x-template" id="contact-list-component">
  <div id="store-contact" class="store-block">
    {foreach $store.contacts as $contact}
      {if $contact.private == "0"}
        <li class="col col--sm-6">
          <h3><strong>{$contact.name}</strong></h3>
          <div><i class="svg-icon svg-phone svg-phone-dims"></i> <span>{$contact.phone}</span></div>
          <div><i class="svg-icon svg-mail svg-mail-dims"></i> <span>{$contact.email}</span></div>
        </li>
      {/if}
    {/foreach}
  </div>
</script>

{* Services table component *}
<script type="text/x-template" id="services-table-component">
  <div id='store-control' class='store-block'>
    <table class='services zebra-blue'>
      <thead>
        <tr>
          <th>{'OP_BOOKING_SERVICE'|tr} (<a href="/optical_services.php">{'OP_BOOKING_LEARN_MORE'|tr}</a>)</th>
          <th class="center-xs">{'OP_BOOKING_SERVICE_DURATION'|tr} ({'OP_BOOKING_SERVICE_MINUTES'|tr})</th>
          <th class="center-xs">{'OP_BOOKING_SERVICE_PRICE'|tr}</th>
        </tr>
      </thead>
      <tbody>
        {foreach $store.services as $service}
          <tr>
            <td>{$service.description.name[$smarty.session.languages_id].content}</td>
            <td class="center-xs">{$service.duration|substr:0:5}</td>
            <td class="center-xs">{$service.price}</td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  </div>  
</script>

{* Appointment component *}
<script type="text/x-template" id="appointment-component">
<div>

  <div id="appointment-calendar">
    {assign var="retPageValue" value=$smarty.server.REQUEST_URI|substr:1}
    {assign var="registerLink" value='create_account.php'|cat:'?retpage='|cat:$retPageValue}
    
    {if !tep_session_is_registered('customer_id')}
      <div class="message_stack-notice">{'OP_BOOKING_MSG_LOGIN_REQUIRED'|tr}</div>
      <form action="login.php" class="display-inline-block">
        <input type="hidden" name="retpage" value="{$retPageValue}" />
        <input type="submit" value="{'OP_BOOKING_LOGIN'|tr}" class="button button-primary"/>
      </form>
      <form action="create_account.php" class="display-inline-block">
        <input type="hidden" name="retpage" value="{$retPageValue}" />
        <input type="submit" value="{'OP_BOOKING_REGISTER'|tr}" class="button button-secondary"/>
      </form>
    {elseif $smarty.const.BRAND_ID != $smarty.session.customer_from_brand}
      <div class="message_stack-notice">{'OP_BOOKING_MSG_BRAND_REQUIRED'|tr}</div>
    {else}

      {* Progress of creating an appointment *}
      <div class="appointment-step-counter" v-if="!is_admin">
        <ol>
          <li :class="setTimeLineClass(1)" @click="setStepTo(1)"><span>{'OP_BOOKING_STEP_1'|tr}</span></li>
          <li :class="setTimeLineClass(2)" @click="setStepTo(2)"><span>{'OP_BOOKING_STEP_2'|tr}</span></li>
          <li :class="setTimeLineClass(3)"><span>{'OP_BOOKING_STEP_3'|tr}</span></li>
        </ol>
      </div>

      {* Step 1 *}
      <div v-if="step === 1" class="appointment-step appointment-step-1 select-arrow-show">
        <p class="appointment-text-info">{'OP_BOOKING_INFO'|tr}</p>
        {if $services == '[]'}
          <div class="message_stack-warning">{'OP_BOOKING_NO_SERVICES'|tr}</div>
        {elseif !$hoursStartsAt || !$hoursEndsAt}
          <div class="message_stack-warning">{'OP_BOOKING_NO_OPENING_HOURS'|tr}</div>
        {else}
          <select-box :options="appointmentTypes" v-model="selectedType" :selected="selectedType">
            <span slot="label">{'OP_BOOKING_SERVICE'|tr} (<a href="/optical_services.php">{'OP_BOOKING_LEARN_MORE'|tr}</a>)</span>
            <option value="0" slot="default">{'OP_BOOKING_SERVICE_PROMPT'|tr}</option>
          </select-box>
        {/if}
      </div>

      {* Step 2 *}
      <div v-else-if="step === 2" class="appointment-step appointment-step-2">
        <div class="row m-b-sm" v-if="!is_admin">
          {* Appointment information *}
          <div class="col col--lg-8 col--md-7 col--sm-12">
            <div class="form-flow-inline" style="margin-bottom: 30px">
              <div class="form-row form-row-replica">
                <label class="form-row-label"><strong>{'OP_BOOKING_SERVICE'|tr}:</strong></label>
                <span><% appointmentTypes[selectedType].name %></span>
              </div>
              <div class="form-row form-row-replica">
                <label class="form-row-label"><strong>{'OP_BOOKING_REMARK'|tr}:</strong></label>
                <textarea id="store-remark" name="remark">{$booking.remark}</textarea>
              </div>
              <div class="form-row form-row-replica">
                <label class="form-row-label"><strong>{'OP_BOOKING_SERVICE_DURATION'|tr}:</strong></label>
                <span><% parseInt(appointmentTypes[selectedType].duration * 30) %> {'OP_BOOKING_SERVICE_MINUTES'|tr}</span>
              </div>
            </div>
          </div>
          {* Calendar Legend *}
          <div class="col col--lg-4 col--md-5 col--sm-12">
            <ul class="appointment-legend right">
              <li class="occupied">{'OP_BOOKING_LEGEND_OCCUPIED'|tr}</li>
              <li class="selected">{'OP_BOOKING_LEGEND_SELECTED'|tr}</li>
              <li class="free">{'OP_BOOKING_LEGEND_FREE'|tr}</li>
            </ul>
          </div>
        </div>
        
        {* Calendar controls *}
        <div class="row appointment-calendar-navigation">
          <div class="col--lg-3 col--md-3 col--sm-3">
            <button type="button" class="appointment-calendar-button" @click="requestPrevCalendarData">
              <i class="svg-arrow-left svg-arrow-left-dims display-inline-block"></i>
            </button>
          </div>
          <div class="col--lg-6 col--md-6 col--sm-6 text-center">
            <div class="select-content select-arrow-show" @click="showDatePicker('{$smarty.session.languages_code}')">
              <div class="select-wrapper">
                <input id="appointment_day_input" type="text" :value="calendarDay.format('DD.MM.YYYY')">
              </div>
            </div>
          </div>
          <div class="col--lg-3 col--md-3 col--sm-3">
            <button type="button" class="appointment-calendar-button float-right" @click="requestNextCalendarData">
              <i class="svg-arrow-right svg-arrow-right-dims display-inline-block"></i>
            </button>
            <div class="clear"></div>
          </div>
        </div>

        {* Calendar Component *}
        <calendar :bookings_days="notAvailableCells" 
          :cells_count="numberOfCells"
          :store_id="storeId"
          :service_id="selectedTypeId"
          ></calendar>
      </div>
      
      {* Step 3 *}
      <div v-else-if="step === 3" class="appointment-step appointment-step-3">
        <h2 style="color: #01559b;margin-top: 1em !important"><strong>{'OP_BOOKING_SUCCESS'|tr}</strong></h2>

        <p>{'OP_BOOKING_SUCCESS_INFO'|tr}</p>
        
        {* Final appointment info returned from Ajax call *}
        <div class="form-flow-inline" style="margin-bottom: 30px">
          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_BOOKING_SERVICE'|tr}:</strong></label>
            <span><% finalAppointment.name %></span>
          </div>

          <div v-if="finalAppointment.remark" class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_BOOKING_REMARK'|tr}:</strong></label>
            <span><% finalAppointment.remark %></span>
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_BOOKING_SERVICE_DURATION'|tr}:</strong></label>
            <span><% getTimeInMinutes(finalAppointment.duration) %> {'OP_BOOKING_SERVICE_MINUTES'|tr}</span>
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_BOOKING_DATE'|tr}:</strong></label>
            <span><% moment(finalAppointment.starts_at).format('DD.MM.YYYY') %></span>
          </div>

          <div class="form-row form-row-replica">
            <label class="form-row-label"><strong>{'OP_BOOKING_TIME'|tr}:</strong></label>
            <span><% moment(finalAppointment.starts_at).format('HH:mm') %> - <% moment(finalAppointment.starts_at).add(getTimeInMinutes(finalAppointment.duration), 'm').format('HH:mm') %></span>
          </div>
        </div>
      </div>
    {/if}
  </div>
</div>
</script>

<link href="/{$smarty.const.DIR_WS_JS}datepicker3.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
{if $smarty.session.languages_id == 2}
  {* DE *}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/de-ch.js"></script>
  <script>moment.locale('de-ch');</script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.de.min.js" charset="UTF-8"></script>
{elseif $smarty.session.languages_id == 3}
  {* FR *}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/fr-ch.js"></script>
  <script>moment.locale('fr-ch');</script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.fr-CH.min.js" charset="UTF-8"></script>
{/if}

<script src="https://unpkg.com/vue/dist/vue.js"></script>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp7Wx3zYcirrHbHJ55bP9Nco7d1wkf4AI&libraries=places&callback=initMap"></script>

{assign var=location value=','|explode:$store.location}
<script>
  $(window).resize(function() {
    initMap();
  });
  var map;
  function initMap() {
    var defaultMapPosition = {};
    defaultMapPosition.lat = parseFloat('{$location[0]}');
    defaultMapPosition.lng = parseFloat('{$location[1]}');
    map = new google.maps.Map(document.getElementById('map-contact'), {
      zoom: 10,
      center: defaultMapPosition,
      mapTypeId: 'roadmap',
      mapTypeControl: false,
      fullscreenControl: false,
      streetViewControl: false,
      rotateControl: false
    });
    var infoWindow = new google.maps.InfoWindow({
      maxWidth: 300
    });
    var position = {};
    position.lat = parseFloat('{$location[0]}');
    position.lng = parseFloat('{$location[1]}');
    var markerInfo = '<div class="popup-partner-details"><h3>{$store.name}</h3><p>{$store.street}, {$store.zip} {$store.city}</p></div>';
    var marker = new google.maps.Marker({
      position: position,
      icon: '/templates/mrlens2/img/svg/map_pin.svg',
      map: map,
    });
    marker.addListener('click', function() {
      setTimeout(function() {
        infoWindow.setContent(markerInfo);
        infoWindow.open(map, marker);
      }.bind(this), 300);
    });
  }
  function showMap() {
    document.getElementById('map-contact').style.display = 'block';
  }
  function hideMap() {
    document.getElementById('map-contact').style.display = 'none';
  }
</script>
