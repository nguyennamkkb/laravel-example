import Client from '../plugins/axios'
const resource = '/api';

export function getExport(data) {
    return Client({
        url: resource + '/export',
        method: 'get',
        params: data
    })
}
// export function getValueExport() {
//     return Client({
//         url: resource + '/valueexport',
//         method: 'get',
//         // params: data
//     })
// }
export function getExportbyId(id, data) {
    return Client({
        url: resource + '/export/' + id,
        method: 'get',
        params: data
    })
}
export function createExport(data) {
    return Client({
        url: resource + '/export',
        method: 'post',
        data
    })
}
export function updateExport(id, data) {
    return Client({
        url: resource + '/export/' + id,
        method: 'put',
        data
    })
}
export function deleteExport(id) {
    return Client({
        url: resource + '/export/' + id,
        method: 'delete',
    })
}