import Client from '../plugins/axios'
const resource = '/api';

export function getInput(data) {
    return Client({
        url: resource + '/input',
        method: 'get',
        params: data
    })
}
export function getValueInput() {
    return Client({
        url: resource + '/valueinput',
        method: 'get',
        // params: data
    })
}
export function getInputbyId(id, data) {
    return Client({
        url: resource + '/input/' + id,
        method: 'get',
        params: data
    })
}
export function createInput(data) {
    return Client({
        url: resource + '/input',
        method: 'post',
        data
    })
}
export function exportFromInput(data) {
    return Client({
        url: resource + '/exportFromInput',
        method: 'post',
        data
    })
}
export function updateInput(id, data) {
    return Client({
        url: resource + '/input/' + id,
        method: 'put',
        data
    })
}
export function deleteInput(id) {
    return Client({
        url: resource + '/input/' + id,
        method: 'delete',
    })
}