import app from 'flarum/admin/app';

app.initializers.add('gm-fire/nexusphp-api', () => {
  app.extensionData
    .for('gm-fire-nexusphp-api')
    .registerSetting({
      setting: 'gm-fire-nexusphp-api.apiurl',
      type: 'text',
      label: app.translator.trans('gm-fire-nexusphp-api.admin.settings.apiurl'),
      placeholder: 'https://www.xxx.com',
      help: app.translator.trans('gm-fire-nexusphp-api.admin.settings.apiurl_help'),
    })
    .registerSetting({
      setting: 'gm-fire-nexusphp-api.secret',
      type: 'text',
      label: app.translator.trans('gm-fire-nexusphp-api.admin.settings.secret'),
      placeholder: 'abcdefghijABCDEFGHIJabcdefghijABCDEFGHIJ',
      help: app.translator.trans('gm-fire-nexusphp-api.admin.settings.secret_help'),
    })
    .registerSetting({
      setting: 'gm-fire-nexusphp-api.seedbonus_open',
      type: 'boolean',
      label: app.translator.trans('gm-fire-nexusphp-api.admin.settings.seedbonus_open'),
    })
    .registerSetting({
      setting: 'gm-fire-nexusphp-api.seedbonus_label',
      type: 'text',
      label: app.translator.trans('gm-fire-nexusphp-api.admin.settings.seedbonus_label'),
      placeholder: app.translator.trans('gm-fire-nexusphp-api.admin.settings.seedbonus_label_placeholder'),
    })
});
