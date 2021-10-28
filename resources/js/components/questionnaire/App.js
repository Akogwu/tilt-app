import React, {useContext, useState,Fragment} from 'react';
import ReactDOM from "react-dom";
import Icon from "@mdi/react";
import { mdiPlusCircle,mdiAccountCircle } from '@mdi/js';
import Groups from "./Groups/Groups";
import GroupAddModal from "./Groups/GroupAddModal";
import SectionAddModal from "./Sections/SectionAddModal";
import Sections from "./Sections/Sections";
import {QuestionContext, QuestionProvider} from "./questions/QuestionContext";
import Questions from "./questions/Questions";
import QuestionAddModal from "./questions/QuestionAddModal";
import AlertMessage from "../Alert";
import GroupOverview from "./Groups/GroupOverview";
import {GroupContext} from "./Groups/GroupContext";

const App = () => {
    const [openGroupModal,setOpenGroupModal] = useState(false);
    const handleCloseGroupModal = ()=> setOpenGroupModal(false);
    const [openSectionAddForm,setOpenSectionAddForm] = useState(false);
    const handleCloseAddSectionForm = () =>  setOpenSectionAddForm(false);
    const [openQuestionAddModal,setOpenQuestionAddModal] = useState(false);
    const handleCloseAddQuestionModal = () =>setOpenQuestionAddModal(false);
    const [openAlert,setOpenAlert] = useState(false);

    const [questions,setQuestions,loadingQuestions,sectionId,setSectionId] = useContext(QuestionContext);

    const [overview] = useContext(GroupContext);

    const handleCloseAlert = () =>{
        setOpenAlert(false);
    }

    const activeAddQuestionModal = () => {
        if (sectionId){
            setOpenQuestionAddModal(true);
        }else {
            setOpenAlert(true);
        }

    }

    return (
        <Fragment>
            {openAlert && <AlertMessage open={openAlert} handleCloseSnack={handleCloseAlert} message={`Please select a section before adding question`} severity={`warning`}/>}
            {openQuestionAddModal && <QuestionAddModal open={openQuestionAddModal} handleClose={handleCloseAddQuestionModal}/>}
            <div className="py-6">
                <div className="flex w-full min-w-full divide-y divide-gray-200">
                    <div onClick={ () => setOpenGroupModal(true) } style={{ backgroundColor:'#e5f3fe', cursor:'pointer' }}   className="p-3 w-1/4 button font-bold" >
                        Groups <Icon path={mdiPlusCircle} size={1} color="#02497f" className="inline"/>
                    </div>

                    <div onClick={ () => setOpenSectionAddForm(true) } style={{ backgroundColor:'#ffdfe1bf',cursor:'pointer' }} className="p-3 w-1/4 font-bold">
                        Sections <Icon path={mdiPlusCircle} size={1} color="#d90804" className="inline"/>
                    </div>

                    <div style={{ backgroundColor:'#e6ffe9',cursor:'pointer' }}  onClick={ () => activeAddQuestionModal() } className="p-3 w-1/2 font-bold text-right">
                        Questions <Icon path={mdiPlusCircle} size={1} color="#147959" className="inline"/>
                    </div>
                </div>
                <div className="flex w-full min-w-full divide-y divide-gray-200">
                    <GroupAddModal open={openGroupModal} handleClose={handleCloseGroupModal}/>
                    <SectionAddModal open={openSectionAddForm} handleClose={handleCloseAddSectionForm}/>
                    <Groups/>
                    <div className="p-3 w-1/4">
                        <Sections/>
                    </div>
                    <div className="p-3 w-1/2">
                        <Questions/>
                    </div>
                </div>
                <hr/>
                <GroupOverview overviewData={overview} />
            </div>
        </Fragment>
    );

}

export default App;
