import { Res } from "@/interface";
import { SendEmailParam, Upload } from "@/interface/public";
import http from "@/utils/http";

// 发送短信验证码
export const sendEmail = http.post<SendEmailParam, Res<any>>('/api/notify/send_email', undefined, { loading: true })



export const upLoadFile = http.post<any, Res<Upload>>(
    "/api/common/image_upload",
    undefined,
    {
        headers: {
            "Content-Type": "multipart/form-data",
        },
        loading: true,
    }
);