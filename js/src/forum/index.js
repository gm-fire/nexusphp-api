import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import PostUser from 'flarum/forum/components/PostUser';
import addSeedBonusAction from './addSeedBonusAction';
import addBonussList from './addBonusList';
import addBonusTabToUserProfile from './addBonusTabToUserProfile';
import MedalsBar from './components/MedalsBar';
import NotificationGrid from 'flarum/forum/components/NotificationGrid';
import PostBonusNotification from './components/PostBonusNotification';
import PostReplyNotification from './components/PostReplyNotification';

export { default as extend } from './extend';

app.initializers.add('gm-fire-nexusphp-api', () => {

  app.notificationComponents.postBonus = PostBonusNotification;
  app.notificationComponents.postReply = PostReplyNotification;

  addSeedBonusAction();
  addBonussList();
  addBonusTabToUserProfile();

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

  extend(NotificationGrid.prototype, 'notificationTypes', function (items) {
    items.add('postBonus', {
      name: 'postBonus',
      icon: 'fas fa-yen-sign',
      label: app.translator.trans('gm-fire-nexusphp-api.forum.settings.notify_post_bonus_label'),
    });
  });

});

// Expose compat API
import bonusCompat from './compat';
import { compat } from '@flarum/core/forum';

Object.assign(compat, bonusCompat);
