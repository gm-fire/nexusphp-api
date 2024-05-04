import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import PostUser from 'flarum/forum/components/PostUser';
import addSeedBonusAction from './addSeedBonusAction';
import MedalsBar from './components/MedalsBar';
import NotificationGrid from 'flarum/forum/components/NotificationGrid';
import PostReplyNotification from './components/PostReplyNotification';

app.initializers.add('gm-fire-nexusphp-api', () => {

  app.notificationComponents.postReply = PostReplyNotification;

  addSeedBonusAction();

  extend(PostUser.prototype, 'view', function (view) {
    const user = this.attrs.post.user();

    if (!user) return;

    view.children.push(MedalsBar.component({ user }));
  });

  extend(NotificationGrid.prototype, 'notificationMethods', function (items) {
    items.add('push', {
      name: 'push',
      icon: 'fas fa-people-arrows',
      label: app.translator.trans('gm-fire-nexusphp-api.forum.settings.push_header'),
    });
  });

  extend(NotificationGrid.prototype, 'notificationTypes', function (items) {
    items.add('postReply', {
      name: 'postReply',
      icon: 'fas fa-pencil-alt',
      label: app.translator.trans('gm-fire-nexusphp-api.forum.settings.notify_post_reply_label'),
    });
  });

});
