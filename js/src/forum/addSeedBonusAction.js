import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import Button from 'flarum/common/components/Button';
import CommentPost from 'flarum/forum/components/CommentPost';
import SeedBonusModal from './components/SeedBonusModal';

export default function () {
  extend(CommentPost.prototype, 'actionItems', function (items) {
    const post = this.attrs.post;

    const user = post.user();

    let isSennd = app.session.user && (user !== app.session.user);

    if (post.isHidden() || !app.forum.attribute('gm-fire-nexusphp-api.seedbonusOpen') || !isSennd) return;

    items.add(
      'seedbonus',
      <Button className="Button Button--link" onclick={() => app.modal.show(SeedBonusModal, { user })}>
        {app.forum.attribute('gm-fire-nexusphp-api.seedbonusLabel')}
      </Button>
    );
  });
}
