import React, {createContext, useEffect, useState} from 'react';
import {apiGet} from "../../utils/ConnectApi";

export const SectionContext = createContext();

export const SectionProvider = (props) => {
    const [sections,setSections] = useState([]);
    const [secGroupId,setSecGroupId]  = useState(0);
    const [loadingSections,setLoadingSections] = useState(false);


    useEffect( () => {
        if (secGroupId > 0){
            setLoadingSections(true);
            apiGet(`groups/${secGroupId}/sections`).then(sections => {
                if (sections && sections.length > 0){
                    setSections(sections);
                }else {
                    setSections([]);
                }
                setLoadingSections(false);
            });
        }
    },[secGroupId]);

    return (
        <SectionContext.Provider value={[sections,setSections,loadingSections,secGroupId,setSecGroupId]}>
            {props.children}
        </SectionContext.Provider>
    );

}

