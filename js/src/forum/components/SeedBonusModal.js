import app from 'flarum/forum/app';
import Modal from 'flarum/common/components/Modal';
import Button from 'flarum/common/components/Button';

import Stream from 'flarum/common/utils/Stream';
import withAttr from 'flarum/common/utils/withAttr';
import ItemList from 'flarum/common/utils/ItemList';

export default class SeedBonusModal extends Modal {
  oninit(vnode) {

    super.oninit(vnode);
    this.seedbonus = Stream(100);
    this.success = false;
    const user = this.attrs.user;
    this.nickname = Stream(user.data.attributes.displayName);
    this.username = Stream(user.data.attributes.username);
    this.uid = Stream(app.session.user.data.id);
  }

  className() {
    return 'SeedBonusModal Modal--medium';
  }

  title() {
    return app.translator.trans('gm-fire-nexusphp-api.forum.seedbonus.title');
  }

  content() {
    if (this.success) {
      return (
        <div className="Modal-body">
          <div className="Form Form--centered">
            <p className="helpText">{app.translator.trans('gm-fire-nexusphp-api.forum.seedbonus.confirmation_message')}</p>
            <div className="Form-group">
              <Button className="Button Button--primary Button--block" onclick={this.hide.bind(this)}>
                {app.translator.trans('gm-fire-nexusphp-api.forum.seedbonus.dismiss_button')}
              </Button>
            </div>
          </div>
        </div>
      );
    }

    return (
      <div className="Modal-body">
        <div className="Form Form--centered">
          <div className="Form-group">
            <input type="number" min="100" autocomplete="off" name="senndbonus" className="FormControl" max="10000000" bidi={this.seedbonus} placeholder={app.translator.trans('gm-fire-nexusphp-api.forum.seedbonus.title_placeholder')} disabled={this.loading}/>
          </div>
          <div className="Form-group">
            <Button className="Button Button--primary Button--block" type="submit" loading={this.loading} disabled={this.loading}>
              {app.translator.trans('gm-fire-nexusphp-api.forum.seedbonus.submit_button')}
            </Button>
          </div>
        </div>
      </div>
    );
  }

  onsubmit(e) {
    e.preventDefault();
    this.loading = true;

    app.request({
      method: "POST",
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': app.forum.attribute("gm-fire-nexusphp-api.secret"),
      },
      url:
        app.forum.attribute("gm-fire-nexusphp-api.apiurl") + "/api/flarum-senndbonus",
      body: {
        uid: this.uid,
        data: {
          nickname: this.nickname,
          username: this.username,
          seedbonus: this.seedbonus,
        }
      },
    })
      .then((data) => {
        this.loading = false;
        m.redraw();
      })
      .catch((error) => {
        this.loading = false;
        m.redraw();
        throw error;
      });

// console.log(this.seedbonus);
    // app.store
    //   .createRecord('seedbonus')
    //   .save(
    //     {
    //       reason: this.reason() === 'other' ? null : this.reason(),
    //       reasonDetail: this.reasonDetail(),
    //       relationships: {
    //         user: app.session.user,
    //         post: this.attrs.post,
    //       },
    //     },
    //     { errorHandler: this.onerror.bind(this) }
    //   )
    //   .then(() => (this.success = true))
    //   .catch(() => {})
    //   .then(this.loaded.bind(this));
  }
}
