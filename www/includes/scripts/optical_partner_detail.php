<?php

use App\OpticalPartners\OpticalPartners as OP;
ConnectedBrands::useMain();

$langId = get_current_language_id();

$id = OP::getId('store');
OP::checkIntegrity($id, 'store');

$partnerId = OP::getId('partner');
OP::checkIntegrity($partnerId, 'partner');

$partner = new OP($partnerId);

if ($partner) {

  $content = $services = [];
  $store = $partner->stores[$id];
  $store['id'] = $id;
  foreach ($store['services'] as $k => $v) {
    $services[$k]['name'] = $v['description']['name'][$langId]['content'];
    $services[$k]['duration'] = $v['duration'];
  }

  $services = json_encode($services);

  foreach ($store['description'] as $k => $v) {
    if (!empty($v[$langId]['content']) || $k == 'booking' || $k == 'contact' || $k == 'control') {
      $headingContent = '<h2>'.t('OP_SECTION_'.strtoupper($k)).'</h2>';
      $additionalContent= '';
      $descriptionContent = $v[$langId]['content'] != '' ? '<div class="m-b-lg">' . $v[$langId]['content'] . '</div>' : '';
      switch($k) {
        case 'booking':
          $additionalContent .= '<appointment-process :store-id="' . $id . '" :services=\'' . $services . '\'></appointment-process>';
          break;
        case 'contact':
          $additionalContent .= '<contact-list/>';
          break;
        case 'control':
          $additionalContent .= '<services-table/>';
          break;
        default:
          break;
      }
      $content[] = [
        'path' => '/' . $k,
        'component' => ['template' => "<div class='store-tpl'>" . $headingContent . $descriptionContent . $additionalContent . "</div>"],
        ];
    }
  }
  $content[] = [
    'path' => '/',
    'redirect' => '/booking'
  ];

  $unOrganizedHours = OP::getStoresHours($id, false);

  $smarty->assign([
    'store' => $store,
    'services' => $services,
    'content' => $content,
    'hoursStartsAt' => count($unOrganizedHours) ? min(array_column($unOrganizedHours, 'starts_at')) : null,
    'hoursEndsAt' => count($unOrganizedHours) ? max(array_column($unOrganizedHours, 'ends_at')) : null,
  ]);

  $smarty->display('optical_partners/detail.tpl');

}