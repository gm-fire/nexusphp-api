import Component from 'flarum/common/Component';
import app from 'flarum/forum/app';
import Tooltip from 'flarum/common/components/Tooltip';

export default class MedalsBar extends Component {
  oninit(vnode) {
    super.oninit(vnode);

    const user = this.attrs.user;
    this.medals = [];

    if (user.data.attributes) {
      app.request({
        method: "GET",
        url: app.forum.attribute("apiUrl") + "/medals",
        params: {
          username: user.data.attributes.username
        }
      })
      .then((data) => {
        this.medals = JSON.parse(data.data.id);
        m.redraw();
      })
    }
  }

  view() {
    const medals = this.medals || [];
    const userUrl = app.data.nexusphpApiPluginSettings.apiurl + '/userdetails.php?id=' + this.attrs.user.data.attributes.username;
    return (
      <>
      <div class="PostUser-medals">
          <span class="PostUser-text">
            {medals.length ? (
              medals.map((medal) => {
                let imgsrc = '<img src=' + medal.image_large + ' data-reaction height="185px" width="185px;"/>';
                return (
                  <Tooltip text={imgsrc} html>
                    <img src={medal.image_small} title={medal.name} data-reaction class="image"/>
                  </Tooltip>
                );
              })
            ) : ""}
          </span>
      </div>
      <div class="PostUser-details"><a href={userUrl} target="_blank">详细资料</a></div>
      </>
    );
  }
}
