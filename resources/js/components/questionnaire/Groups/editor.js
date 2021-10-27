import React, { useEffect, useState,  } from "react";
import { Editor } from "react-draft-wysiwyg";
import { EditorState, ContentState, convertToRaw } from "draft-js";
import "react-draft-wysiwyg/dist/react-draft-wysiwyg.css";
import draftToHtml from "draftjs-to-html";
import htmlToDraft from "html-to-draftjs";

export const CustomTextEditor = ({ id, value = "<p></p>", callback, readonly=false }) => {
    const [editorState, seteditorState] = useState(EditorState.createEmpty());
    useEffect(() => {
        const contentBlock = htmlToDraft(value || "<p></p>");
        const contentState = ContentState.createFromBlockArray(
            contentBlock.contentBlocks
        );
        seteditorState(EditorState.createWithContent(contentState));
        
    }, []);
    
    useEffect(()=>{
        save();
    },[editorState]);

    const onEditorStateChange = (editorState) => {
        seteditorState(editorState);
    };

    const save = () => {
        callback &&
            callback(
                draftToHtml(convertToRaw(editorState.getCurrentContent()))
            );
    };

    const uploadImage = (file) => {
        return new Promise(function (resolve, reject) {
            let reader = new FileReader();
            reader.onload = (e) => {
                return startUploader(e?.target?.result);
            };
            reader.readAsDataURL(file);

            const startUploader = (e) => {
                // apiPut(
                //     { image: e },
                //     "/api/admin/general/data/upload-file-only/new"
                // ).then((res) => {
                //     resolve({ data: { link: res?.url } });
                // });
            };
        });
    };
    if(readonly){
        return (
            <div
                className={
                    "form-control ql-tooltip ql-editing show question-option-img readonly"
                }
                style={{ border: "none", height: "auto" }}
                dangerouslySetInnerHTML={{ __html: value }}
            />
        )
    }
    
    return (
        <div className="bg-gray-50">
            <Editor
                editorState={editorState}
                wrapperClassName="demo-wrapper"
                editorClassName="demo-editor"
                onEditorStateChange={(e) => onEditorStateChange(e)}
                name="resource"
                // toolbar={{
                //     image: {
                //         // icon: "image",
                //         className: undefined,
                //         component: undefined,
                //         popupClassName: undefined,
                //         urlEnabled: false,
                //         uploadEnabled: true,
                //         alignmentEnabled: true,
                //         uploadCallback: (e) => uploadImage(e),
                //         previewImage: true,
                //         inputAccept:
                //             "image/gif,image/jpeg,image/jpg,image/png,image/svg",
                //         alt: { present: false, mandatory: false },
                //         defaultSize: {
                //             height: "auto",
                //             width: "auto",
                //         },
                //     },
                // }}
            />
            {/* <div style={{ position: "absolute", right: 8, bottom: 40, zIndex: 900000 }}>
                <a
                    href="#"
                    onClick={(e) => {
                        e.preventDefault();
                        save();
                    }}
                    className="plus-item-to-option btn btn-clean btn-hover-light-primary btn-sm btn-icon"
                >
                    Save
                </a>
            </div> */}
        </div>
    );
};