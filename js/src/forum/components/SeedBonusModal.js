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
      url:
        app.forum.attribute("apiUrl") + "/seedbonus",
      body: {
        data: {
          nickname: this.nickname,
          username: this.username,
          seedbonus: this.seedbonus,
        }
      },
    })
      .then((data) => {
        this.loading = false;
        this.success = true;
        m.redraw();
      })
      .catch((error) => {
        this.loading = false;
        m.redraw();
        throw error;
      });
  }
}
