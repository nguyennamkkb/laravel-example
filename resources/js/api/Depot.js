import Client from '../plugins/axios'
const resource = '/api';

export function filterCode(data) {
    return Client({
        url: resource + '/codes',
        method: 'get',
        params: data
    })
}
export function getCode() {
    return Client({
        url: resource + '/codes',
        method: 'get',
    })
}
export function createCode() {
    return Client({
        url: resource + '/codes',
        method: 'post',
    })
}
export function updateCode(id, data) {
    return Client({
        url: resource + '/codes/' + id,
        method: 'put',
        params: data
    })
}
export function deleteCode(id) {
    return Client({
        url: resource + '/codes/' + id,
        method: 'delete',
    })
}