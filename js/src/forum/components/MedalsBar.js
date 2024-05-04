import Component from 'flarum/common/Component';
import app from 'flarum/forum/app';
import Tooltip from 'flarum/common/components/Tooltip';

export default class MedalsBar extends Component {
  oninit(vnode) {
    super.oninit(vnode);
  }

  view() {
    const user = this.attrs.user;

    return (
      <div class="PostUser-medals">
          <span class="PostUser-text">
            <Tooltip text='<img src="https://img.agsv.top/i/2024/03/29/7im6x.gif" height="185ßpx" width="185px;"/>' html>
            <img src="https://img.agsv.top/i/2024/03/29/7im6x.gif" title="开发组" style="max-height: 15px;max-width: 15px;margin-left: 2pt"/>
            </Tooltip>
            <Tooltip text='<img src="https://img.agsv.top/i/2024/04/07/wjai.gif" height="185ßpx" width="185px;"/>' html>
            <img src="https://img.agsv.top/i/2024/04/07/wjai.gif" title="发布组" style="max-height: 15px;max-width: 15px;margin-left: 2pt"/>
            </Tooltip>
            <Tooltip text='<img src="https://img.agsv.top/i/2024/04/12/zvha.gif" height="185ßpx" width="185px;"/>' html>
            <img src="https://img.agsv.top/i/2024/04/12/zvha.gif" title="末日大富豪" style="max-height: 15px;max-width: 15px;margin-left: 2pt"/>
            </Tooltip>
          </span>
      </div>
    );
  }
}
