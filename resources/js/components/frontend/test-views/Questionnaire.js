import React, { Component } from "react";
import { Button, Spinner } from "react-bootstrap";
import { Stepper, Step, StepLabel } from "@material-ui/core";
import QuestionGroupSection from "./view-sections/QuestionGroupSection";
import PageHeadingSection from "./sections/PageHeadingSection";
import Section from "./view-sections/Section";
import ProgressBar from "./view-sections/ProgressBar";
import QuestionItem from "./view-sections/QuestionItem";
import PageButtonIconRight from "./snippets/PageButtonIconRight";
import PageButtonIconLeft from "./snippets/PageButtonIconLeft";
import PageButtonSubmit from "./snippets/PageButtonSubmit";
import axios from "axios";
import config from "./helpers/Config";
import AlertMessage from "./Alert";

import isEmpty from "./utils/is-empty";
import ReactDOM from "react-dom";
import {apiPost} from "../../utils/ConnectApi";


const Helpers = require("./helpers/Helpers");

class Questionnaire extends Component {
    constructor(props) {
        super(props);

        this.state = {
            groups: [],
            currentGroup: {},
            currentGroupIndex: 0,
            sections: [],
            currentGroupSections: [],
            currentSection: {},
            currentSectionIndex: 0,
            questions: [],
            currentSectionQuestions: [],
            nextGroup: {},
            previousGroup: {},
            nextSection: {},
            previousSection: {},
            progressBarValue: 0,
            currentColor: null,
            complete: false,
            isLoading: true,
            loading: false,
            isCurrentSectQuestComplete: false,
            openMessage: false,
            message: "",
            severity: "",
            completeAnsweredQuestions: [],
            answeredSectionQuestions: [],
            opacity: 0.5,
            activeQuestion: {},

        };
    }

    async componentDidMount() {
        await this.getQuestionnaireDataApi(); // loads Questionnaire data via Api

        let {
            groups,
            currentGroup,
            currentSection,
            currentSectionQuestions,
            currentColor,
        } = this.state;

        this.setStateVariables(
            groups,
            currentGroup,
            currentSection,
            currentSectionQuestions,
            currentColor
        );
    }

    //sets values of state variables
    setStateVariables = (
        groups = this.state.groups,
        currentGroup,
        currentGroupSections,
        currentSection,
        currentSectionQuestions,
        currentColor
    ) => {
        let {
            currentGroupIndex,
            currentSectionIndex,
            nextGroup,
            previousGroup,
            nextSection,
            previousSection,
            isLoading,
            activeQuestion,
        } = this.state;

        if (!isEmpty(this.state.groups)) {
            groups = this.state.groups;
            currentGroup = groups[currentGroupIndex]; // gets group with index 'currentGroupIndex'
            nextGroup = groups[currentGroupIndex + 1]; // gets next group
            previousGroup =
                currentGroupIndex > 0 ? groups[currentGroupIndex - 1] : null; //gets previous group
            currentGroupSections = groups[currentGroupIndex].sections; //gets all sections of current group only
            currentSection = currentGroup.sections[currentSectionIndex]; // gets current section with index 'currentSectionIndex'
            nextSection = currentGroup.sections[currentSectionIndex + 1];
            previousSection = //
                currentSectionIndex > 0 //
                    ? currentGroup.sections[currentSectionIndex - 1] //// gets previous section
                    : null;
            currentSectionQuestions = currentSection?.questions; // gets current questions from current section
            currentColor = currentGroup.color;
            isLoading = false;
            activeQuestion = currentSectionQuestions[0];

            this.setState({
                currentGroup,
                nextGroup,
                previousGroup,
                currentGroupSections,
                currentSection,
                nextSection,
                previousSection,
                currentSectionQuestions,
                currentColor,
                isLoading,
                activeQuestion,
            });
        }
    };

    // loads questionnaire data from API
    async getQuestionnaireDataApi() {
        await axios
            .get(config.apiBaseUrl + "test/get-questions")
            .then((res) => {
                if (res.status) {
                    this.setState({ loading: false });
                    this.setState({ groups: res.data });
                } else {
                    this.setState({ loading: false });
                    alert("Could not retrieve questions, Please reload");
                }
            }).catch((err) => {
                try {
                    console.log(err.response.data);
                    return err.response.data;
                } catch (error) {
                    console.log(error);
                }
            });
    }

    // displays list of question groups on screen
    renderGroups = () => {
        const { groups } = this.state;

        return groups.map((group, index) => {
            return (
                <Button key={index}  variant={this.currentGroupButtonColor(group)}>
					<span>
						<i className={`fa fa-3x fa-${group.icon} pl-2 pr-2`}> </i>
					</span>
                    {group.name.toUpperCase()}
                </Button>
            );
        });
    };

    // gets color of the current group
    currentGroupButtonColor = (group) => {
        const { currentGroup } = this.state;
        if (!isEmpty(currentGroup) && !isEmpty(group)) {
            if (currentGroup.group_id === group.group_id) {
                return currentGroup.color;
            }
        }
        return "gray-400";
    };

    // displays spinner on screen
    showSpinner = (size = "lg", color = "primary") => (
        <Spinner animation="grow" size={size} aria-hidden="true" variant={color} />
    );

    //renders sections belonging to the current group
    renderGroupSections = () => {
        const { currentGroupSections, currentGroup } = this.state;

        if (!isEmpty(currentGroupSections)) {
            return currentGroupSections.map((section, index) => (
                <Step key={section + index}>
                    <StepLabel>{Helpers.titleCase(section.name)}</StepLabel>
                </Step>
            ));
        } else {
            this.renderNoItemFoundMsg(
                "No section(s) found for the group: " + !isEmpty(currentGroup.name)
                    ? currentGroup.name
                    : null
            );
        }
    };

    // displays message on screen
    renderNoItemFoundMsg = (message) => {
        return (
            <span
                style={{
                    fontSize: 20,
                    fontWeight: "700",
                    color: "grey",
                    justifySelf: "center",
                }}
            >
				{message}
			</span>
        );
    };

    // calculates progress bar value and sets its state
    setProgress() {
        const totalAnswered = this.state.completeAnsweredQuestions.length;
        const totalQuestions = this.getAllQuestionsCount();
        const progressBarValue = Math.round((totalAnswered / totalQuestions) * 100);
        this.setState({ progressBarValue });
    }

    //gets total number of questions
    getAllQuestionsCount() {
        const { groups } = this.state;
        let questionsCount = 0;

        groups.forEach((group) => {
            let sections = group.sections;
            sections.forEach((section) => {
                questionsCount += section.questions.length;
            });
        });
        return questionsCount;
    }

    //renders questions belonging to current section
    renderQuestions = () => {
        const {
            currentSectionQuestions,
            currentSection,
            activeQuestion,
        } = this.state; //NOTE: currentSectionQuestions == currentSection.questions

        if (!isEmpty(currentSectionQuestions)) {
            return currentSectionQuestions.map((questionObject, index) => (
                <QuestionItem
                    key={index}
                    question={questionObject.question}
                    weight_points={questionObject.weight_points}
                    color={this.state.currentColor}
                    answer_id={this.getQuestionAnswer(questionObject)}
                    options_id={index}
                    onAnswer={(value) => this.handleAnswer(questionObject, value)}
                    activeQuestion={activeQuestion.question}
                />
            ));
        } else {
            this.renderNoItemFoundMsg(
                "Question found for the section: " + !isEmpty(currentSection.name)
                    ? currentSection.name
                    : null
            );
        }
    };

    // adds an answered question to a set of already answered questions
    updateCompletedQuestions = (questionID, answer) => {
        const completeAnsweredQuestions = this.state.completeAnsweredQuestions.filter(
            (question, index) => question.questionnaire_id !== questionID
        );

        completeAnsweredQuestions.push({
            questionnaire_id: questionID,
            weight_point_id: answer,
        });

        this.setState({ completeAnsweredQuestions });
    };

    // gets answer to a question
    getQuestionAnswer = (question) => {
        const { completeAnsweredQuestions } = this.state;

        let answer_id = 0;

        completeAnsweredQuestions.forEach((answeredQuestion) => {
            answer_id =
                answeredQuestion.questionnaire_id === question.questionnaire_id // checks whether question exists in list of answered questions (i.e. completeAnsweredQuestions)
                    ? answeredQuestion.weight_point_id
                    : answer_id;
        });

        return answer_id;
    };

    // sets question answer to list of completed questions and auto scrolls to next question
    handleAnswer = async (questionObj, answer) => {
        await this.updateCompletedQuestions(questionObj.questionnaire_id, answer);
        this.setProgress();

        const { completeAnsweredQuestions, currentSectionQuestions } = this.state;

        if (
            this.isSectionQuestionsAnswered(
                completeAnsweredQuestions,
                currentSectionQuestions
            )
        ) {
            this.setState({ isCurrentSectQuestComplete: true });
        }

        const nextId = this.nextQuestionId(questionObj);

        const question_id = document.getElementById(nextId);

        if (nextId >= 0) {
            question_id.scrollIntoView(
                {
                    behavior: "smooth",
                    block: "center",
                    inline: "center",
                },
                500
            );

            this.setState({
                activeQuestion: currentSectionQuestions[nextId],
            });
        }

        // checks whether all questions have been answered
        if (this.isAllQuestionsAnswered()) {
            this.setState({
                complete: true,
            });
        }
    };

    // gets id of the next question to be scroll viewed to
    nextQuestionId = (questionObj) => {
        const { currentSectionQuestions, completeAnsweredQuestions } = this.state;

        let index = -1;

        index = currentSectionQuestions.indexOf(questionObj);

        if (
            index >= 0 &&
            index < currentSectionQuestions.length - 1 &&
            !completeAnsweredQuestions.includes(currentSectionQuestions[index + 1])
        ) {
            // if current question view is the last question, scroll view to first question
            return index + 1;
        }
        return index;
    };

    //checks if all questions in a section are answered
    isSectionQuestionsAnswered = (answeredQuestions, sectionQuestions) => {
        const completeAnsweredQuestions = answeredQuestions.map(
            (a) => a.questionnaire_id
        );
        const currentSectionQuestions = sectionQuestions.map(
            (b) => b.questionnaire_id
        );

        return currentSectionQuestions.every((v) =>
            completeAnsweredQuestions.includes(v)
        ); // returns true if every question is already answered
    };

    //checks if all questions are answered
    isAllQuestionsAnswered = () => {
        const { completeAnsweredQuestions, groups } = this.state;

        const answeredQuestions = completeAnsweredQuestions.map(
            (a) => a.questionnaire_id
        );

        const allQuestions = [];
        groups.forEach((group) => {
            group.sections.forEach((section) => {
                section.questions.forEach((question) => {
                    allQuestions.push(question.questionnaire_id);
                });
            });
        });

        return allQuestions.every((v) => answeredQuestions.includes(v)); // returns true if every question is already answered
    };

    setOpentMessage = ($severity, $message) => {
        this.setState({
            message: $message,
            openMessage: true,
            severity: $severity,
        });
    };

    closeMessage = () => {
        this.setState({ openMessage: false });
    };

    /* renders next button */
    rendersNextButton = () => {
        return this.state.isCurrentSectQuestComplete ? ( // to changed , !  will be removed
            <PageButtonIconRight
                id="next-button"
                icon={"fa-arrow-right"}
                text={"Next"}
                color={this.state.currentColor || "gray"}
                onClick={(e) => this.handleNext(e)}
            />
        ) : (
            <PageButtonIconRight
                icon={"fa-arrow-right"}
                text={"Next"}
                color={this.state.currentColor || "gray"}
                onClick={(e) =>
                    this.setOpentMessage(
                        "warning",
                        "Please answer all questions in this section"
                    )
                }
            />
        );
    };

    /* renders previous button */
    renderPreviousButton = () => {
        return (
            <PageButtonIconLeft
                id="previous-button"
                icon={"fa-arrow-left"}
                text={"Previous"}
                color={this.state.currentColor || "gray"}
                onClick={(e) => this.handlePrevious(e)}
            />
        );
    };

    //displays submit button
    renderSubmitButton = () => {
        return (
            <PageButtonSubmit
                icon={"fa-paper-plane"}
                text={"Submit"}
                color={this.state.currentColor || "gray"}
                onClick={(e) => this.submitQuestions(e)}
            />
        );
    };

    /// submits questions
    submitQuestions = async (e) => {
        e.preventDefault();
        this.setState({ isLoading: true });
        //localStorage.removeItem("@detailedResults");

        if (this.state.completeAnsweredQuestions.length === 0) {
            alert("You did not answer any Questionnaire");
            //this.setOpentMessage("error", "You did not answer any Questionnaire");
            return;
        }

        if (this.state.progressBarValue !== 100) {
            this.setOpentMessage("error", "Seems you did not answer all questions.");
            this.setState({ isLoading: false });
            return;
        }
        let testSession = {};
        const sessionId = localStorage.getItem("session_id");
        testSession.session_id = sessionId;
        testSession.questionnaire = this.state.completeAnsweredQuestions;
        await apiPost(testSession,'test/submit').then(res => {
            if (res.status){
                this.setState({ isLoading: false });
                window.location.href = `/result/${sessionId}/home`;
            }
        });

        // await axios.post(config.apiBaseUrl + "test/submit", testSession)
        //     .then((res) => {
        //         console.log(res);
        //         // if (res.status) {
        //         //     this.setState({ isLoading: false });
        //         //     this.props.history.replace("/test/summary-result", {
        //         //         sessionId: testSession.session_id,
        //         //     });
        //         // } else {
        //         //     this.setState({ loading: false });
        //         //     alert("Could not submit test, Please reload");
        //         // }
        //     }).catch((err) => {
        //         this.setState({ isLoading: false });
        //         alert("Error submitting Test, check your network connectivity");
        //     });
    };

    handleNext = async (e) => {
        e.preventDefault();
        const group_id = document.getElementById("group_id");
        group_id.scrollIntoView(
            {
                behavior: "smooth",
            },
            500
        );

        const {
            groups,
            currentGroup,
            currentGroupSections,
            currentSection,
            currentSectionQuestions,
            currentColor,
            nextSection,
            currentGroupIndex,
            currentSectionIndex,
            completeAnsweredQuestions,
        } = this.state;

        if (
            currentGroupIndex < groups.length &&
            currentSection.name !==
            groups[groups.length - 1].sections[
            groups[groups.length - 1].sections.length - 1
                ].name
        ) {
            // if current group is the last group then question should terminate
            if (!isEmpty(nextSection)) {
                //if next group is not empty, make it current section

                const isAnswered = this.isSectionQuestionsAnswered(
                    completeAnsweredQuestions,
                    nextSection.questions
                ); // checks whether all questions in current section are answered

                this.setState(
                    (prevState) => ({
                        currentSectionIndex: prevState.currentSectionIndex + 1, // advancing from current section to next section
                        isCurrentSectQuestComplete: isAnswered,
                    }),
                    () => {
                        this.setStateVariables(
                            groups,
                            currentGroup,
                            currentGroupSections,
                            currentSection,
                            currentSectionQuestions,
                            currentColor
                        );
                    }
                );
            } else {
                const isAnswered = this.isSectionQuestionsAnswered(
                    completeAnsweredQuestions,
                    groups[currentGroupIndex + 1].sections[0].questions
                ); // checks whether all questions in current section are answered

                this.setState(
                    (prevState) => ({
                        currentGroupIndex: prevState.currentGroupIndex + 1,
                        currentSectionIndex: 0,
                        isCurrentSectQuestComplete: isAnswered,
                    }),
                    () => {
                        this.setStateVariables(
                            groups,
                            currentGroup,
                            currentGroupSections,
                            currentSection,
                            currentSectionQuestions,
                            currentColor
                        );
                    }
                );
            }
        } else {
            this.setState({
                complete: true, // set 'complete' state 'true', signifies that all questions are answered and ready for submit
            });
        }
    };

    handlePrevious = async (e) => {
        e.preventDefault();
        const group_id = document.getElementById("group_id");
        group_id.scrollIntoView(
            {
                behavior: "smooth",
            },
            500
        );

        const {
            groups,
            previousGroup,
            currentGroup,
            currentGroupSections,
            currentSection,
            currentSectionQuestions,
            currentColor,
            previousSection,
            currentGroupIndex,
            completeAnsweredQuestions,
        } = this.state;

        if (!isEmpty(previousGroup)) {
            // if previous group is not empty, go to previous section
            if (!isEmpty(previousSection)) {
                //if previous group is not empty, make it current section

                const isAnswered = this.isSectionQuestionsAnswered(
                    completeAnsweredQuestions,
                    previousSection.questions
                ); // checks whether all questions in current section are answered

                this.setState(
                    (prevState) => ({
                        currentSectionIndex: prevState.currentSectionIndex - 1, // advancing from current section to previous section
                        complete: false,
                        isCurrentSectQuestComplete: isAnswered,
                    }),
                    () => {
                        this.setStateVariables(
                            groups,
                            currentGroup,
                            currentGroupSections,
                            currentSection,
                            currentSectionQuestions,
                            currentColor
                        );
                    }
                );
            } else {
                const isAnswered = this.isSectionQuestionsAnswered(
                    completeAnsweredQuestions,
                    groups[currentGroupIndex - 1].sections[
                    groups[currentGroupIndex - 1].sections.length - 1
                        ].questions
                ); // checks whether all questions in current section are answered

                this.setState(
                    (prevState) => ({
                        currentGroupIndex: prevState.currentGroupIndex - 1, // loads previous group
                        currentSectionIndex:
                            groups[prevState.currentGroupIndex - 1].sections.length - 1, // sets currentSectionIndex to index of last section to in previous group
                        complete: false,
                        isCurrentSectQuestComplete: isAnswered,
                    }),
                    () => {
                        this.setStateVariables(
                            groups,
                            currentGroup,
                            currentGroupSections,
                            currentSection,
                            currentSectionQuestions,
                            currentColor
                        );
                    }
                );
            }
        }
    };

    render() {
        return (
            <main>
                <PageHeadingSection
                    pageTitle={"TILT TEST"}
                    pageTitleColor={"gray"}
                    pt={0}
                    pb={7}
                >
                    <div className="alert alert-tertiary">
                        <h4 className="text-bold text-white m-0">
                            Please answer every question honestly
                        </h4>
                    </div>
                </PageHeadingSection>

                <QuestionGroupSection>
                    {this.state.groups ? this.renderGroups() : this.showSpinner("lg")}
                </QuestionGroupSection>

                <ProgressBar
                    progress={this.state.progressBarValue}
                    color={this.state.currentColor}
                />

                <Section>
                    <div className="w-100">
                        <Stepper
                            activeStep={
                                this.state.currentSection && this.state.currentSectionIndex
                            }
                            alternativeLabel
                        >
                            {this.renderGroupSections()}
                        </Stepper>
                    </div>
                </Section>

                {this.state.loading ? (
                    this.showSpinner("lg")
                ) : (
                    <div className="mb-10 mt-5">
                        <AlertMessage
                            open={this.state.openMessage}
                            message={this.state.message}
                            closeMessage={this.closeMessage}
                            severity={this.state.severity}
                        />

                        <Section>
                            {this.renderQuestions()}
                            <div className="container d-flex justify-content-center">
                                {this.state.isLoading ? (
                                    this.showSpinner("lg")
                                ) : (
                                    <>
                                        <span>{this.renderPreviousButton()}</span>

                                        <span>
											{this.state.complete
                                                ? this.renderSubmitButton()
                                                : this.rendersNextButton()}
										</span>
                                    </>
                                )}
                            </div>
                        </Section>
                    </div>
                )}
            </main>
        );
    }
}

export default Questionnaire;
if (document.getElementById('question-component')) {
    ReactDOM.render(<Questionnaire />, document.getElementById('question-component'));
}
