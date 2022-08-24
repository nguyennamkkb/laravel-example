import Client from '../plugins/axios'
const resource = '/api';

export function getListVau(data) {
    return Client({
        url: resource + '/thanhtoanvau',
        method: 'get',
        params: data
    })
}