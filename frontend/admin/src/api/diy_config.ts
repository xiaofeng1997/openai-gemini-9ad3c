import request from '@/utils/request'


/**
 * 修改自定义页面分享内容
 * @param params
 */
export function editDiyPageShare(params: Record<string, any>) {
    return request.put(`diy/diy/share`, params, { showSuccessMessage: true })
}
/**
 * 获取自定义链接列表
 */
export function getLink(params: Record<string, any>) {
    return request.get(`diy/link`, { params })
}

/**
 * 获取底部导航列表
 */
export function getDiyBottomList(params: Record<string, any>) {
    return request.get(`diy/bottom`, { params })
}

/**
 * 获取底部导航数据
 */
export function getDiyBottomConfig(params: Record<string, any>) {
    return request.get(`diy/bottom/config`, { params })
}

/**
 * 设置底部导航数据
 * @param params
 * @returns
 */
export function setDiyBottomConfig(params: Record<string, any>) {
    return request.post('diy/bottom', params, { showSuccessMessage: true })
}
