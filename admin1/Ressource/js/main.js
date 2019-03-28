/**
 * Created by yuri coco on 10-Feb-16.
 */

function imgError(image) {
    image.onerror = "";
    image.src = "app/Ressource/default/no_image.png";
    return true;
}