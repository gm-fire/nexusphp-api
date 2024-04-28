import { extend } from 'flarum/common/extend';
import NotificationGrid from 'flarum/forum/components/NotificationGrid';

app.initializers.add('gm-fire-nexusphp-api', () => {

  extend(NotificationGrid.prototype, 'notificationMethods', function (items) {
    items.add('push', {
      name: 'push',
      icon: 'fas fa-people-arrows',
      label: app.translator.trans('gm-fire-nexusphp-api.forum.settings.push_header'),
    });
  });

});
