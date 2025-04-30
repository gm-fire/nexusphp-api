import User from 'flarum/common/models/User';

declare module 'flarum/common/models/Post' {
  export default interface Post {
    bonus(): User[];
    bonusCount(): number;
  }
}
