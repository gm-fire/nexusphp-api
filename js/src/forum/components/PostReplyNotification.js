import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';
import { truncate } from 'flarum/common/utils/string';

export default class PostReplyNotification extends Notification {
  icon() {
    return 'fas fa-pencil-alt';
  }

  href() {
    return app.route.post(this.attrs.notification.subject());
  }

  content() {
    const notification = this.attrs.notification;
    const user = notification.fromUser();

    return app.translator.trans('gm-fire-nexusphp-api.forum.notifications.post_reply_text', { user, count: 1 });
  }

  excerpt() {
    return truncate(this.attrs.notification.subject().contentPlain(), 200);
  }
}
