import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import CommentPost from 'flarum/forum/components/CommentPost';
import Link from 'flarum/common/components/Link';
import punctuateSeries from 'flarum/common/helpers/punctuateSeries';
import username from 'flarum/common/helpers/username';
import icon from 'flarum/common/helpers/icon';
import Button from 'flarum/common/components/Button';

export default function () {
  extend(CommentPost.prototype, 'footerItems', function (items) {
    const post = this.attrs.post;
    const bonus = post.bonus();

    if (bonus && bonus.length) {
      const limit = 4;
      const overLimit = post.bonusCount() > limit;

      const names = bonus
        .sort((a) => (a === app.session.user ? -1 : 1))
        .slice(0, overLimit ? limit - 1 : limit)
        .map((user) => {
          return (
            <Link href={app.route.user(user)}>
              {user === app.session.user ? app.translator.trans('gm-fire-nexusphp-api.forum.post.you_text') : username(user)}
            </Link>
          );
        });

      // If there are more users that we've run out of room to display, add a "x
      // others" name to the end of the list. Clicking on it will display a modal
      // with a full list of names.
      if (overLimit) {
        const count = post.bonusCount() - names.length;
        const label = app.translator.trans('gm-fire-nexusphp-api.forum.post.others_link', { count });
        names.push(<span>{label}</span>);
      }

      items.add(
        'bonus',
        <div className="Post-bonusBy">
          {icon('fas fa-yen-sign')}
          {app.translator.trans(`gm-fire-nexusphp-api.forum.post.bonus_by_text`, {
            count: names.length,
            users: punctuateSeries(names),
          })}
        </div>
      );
    }
  });
}
