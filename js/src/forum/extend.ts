import Extend from 'flarum/common/extenders';
import Post from 'flarum/common/models/Post';
import User from 'flarum/common/models/User';
import BonusUserPage from './components/BonusUserPage';

export default [
  new Extend.Routes() //
    .add('user.bonus', '/u/:username/bonus', BonusUserPage),

  new Extend.Model(Post) //
    .hasMany<User>('bonus')
    .attribute<number>('bonusCount'),
];
