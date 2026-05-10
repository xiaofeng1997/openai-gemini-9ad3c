import request from '@/utils/request'

/**
 * 获取自定义页面信息
 */
export function getDiyInfo(params: Record<string, any>) {
    return request.get('diy/diy', params)
}

