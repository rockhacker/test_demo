import { Page, Res } from "@/interface";
import { Banner } from "@/interface/app";
import http from "@/utils/http";

export const getBanner = http.get<{ category_id: number }, Res<Page<Banner[]>>>('/api/news/list', { category_id: 23 })