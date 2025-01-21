// @/utils/emitter.ts
import mitt from "mitt";

type Events = {
  onShow: string;
  onHide: string;
};

const emitter = mitt<Events>();
export default emitter;
