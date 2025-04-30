import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import UserPage from 'flarum/forum/components/UserPage';
import LinkButton from 'flarum/common/components/LinkButton';
import ItemList from 'flarum/common/utils/ItemList';
import type Mithril from 'mithril';

export default function addBonusTabToUserProfile() {
  extend(UserPage.prototype, 'navItems', function (items: ItemList<Mithril.Children>) {
    const user = this.user;
    items.add(
      'bonus',
      <LinkButton href={app.route('user.bonus', { username: user?.slug() })} icon="fas fa-yen-sign">
        {app.translator.trans('gm-fire-nexusphp-api.forum.user.bonus_link')}
      </LinkButton>,
      88
    );
  });
}
