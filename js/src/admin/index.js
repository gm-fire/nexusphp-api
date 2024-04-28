import app from 'flarum/admin/app';

app.initializers.add('gm-fire/nexusphp-api', () => {
  app.extensionData
    .for('gm-fire-nexusphp-api')
    .registerSetting({
      setting: 'nexusphp-api.secret',
      type: 'text',
      label: app.translator.trans('gm-fire-nexusphp-api.admin.settings.secret'),
    })
    // .registerPermission(
    //   {
    //     icon: 'fas fa-user-tag',
    //     label: app.translator.trans('gm-fire-nexusphp-api.admin.permissions.edit_own_nickname_label'),
    //     permission: 'user.editOwnNickname',
    //   },
    //   'start'
    // );
});
