import request from '@/utils/request'
// 通告管理
const url = '/admin/setting.Notice/'
/**
 * 通告列表
 * @param {array} params 请求参数
 */
export function list(params) {
  return request({
    url: url + 'list',
    method: 'get',
    params: params
  })
}
/**
 * 通告信息
 * @param {array} params 请求参数
 */
export function info(params) {
  return request({
    url: url + 'info',
    method: 'get',
    params: params
  })
}
/**
 * 通告添加
 * @param {array} data 请求数据
 */
export function add(data) {
  return request({
    url: url + 'add',
    method: 'post',
    data
  })
}
/**
 * 通告修改
 * @param {array} data 请求数据
 */
export function edit(data) {
  return request({
    url: url + 'edit',
    method: 'post',
    data
  })
}
/**
 * 通告删除
 * @param {array} data 请求数据
 */
export function dele(data) {
  return request({
    url: url + 'dele',
    method: 'post',
    data
  })
}
/**
 * 通告修改类型
 * @param {array} data 请求数据
 */
export function edittype(data) {
  return request({
    url: url + 'edittype',
    method: 'post',
    data
  })
}
/**
 * 通告时间范围
 * @param {array} data 请求数据
 */
export function datetime(data) {
  return request({
    url: url + 'datetime',
    method: 'post',
    data
  })
}
/**
 * 通告是否禁用
 * @param {array} data 请求数据
 */
export function disable(data) {
  return request({
    url: url + 'disable',
    method: 'post',
    data
  })
}
