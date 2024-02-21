import DomAccess from "src/helper/dom-access.helper";
import HttpClient from 'src/service/http-client.service';

export class CmsBlockAdvicePlugin extends window.PluginBaseClass {
    static options = {
        path: '',
    }

    init() {
        this._client = new HttpClient();

        this._fetchData();
    }

    _fetchData() {
        this._client.get(this.options.path, this._handleData.bind(this), 'application/json', true)
    }

    _handleData(response) {
        const AdviceContentEl = DomAccess.querySelector(this.el, '.advice-content');
        AdviceContentEl.innerHTML = JSON.parse(response).advice;
    }
}