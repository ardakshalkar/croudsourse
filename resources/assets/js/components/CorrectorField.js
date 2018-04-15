//'use strict';
import React, { Component } from 'react';
import {convertToRaw,CompositeDecorator,ContentState,Editor,EditorState,RichUtils} from 'draft-js';
import { render } from 'react-dom';
/*const {
  convertToRaw,
  CompositeDecorator,
  ContentState,
  Editor,
  EditorState,
  RichUtils,
} = Draft;*/

export default class CorrectorField extends Component {
  constructor(props) {
    super(props);

    const decorator = new CompositeDecorator([
      {
        strategy: findLinkEntities,
        component: Link,
      },
    ]);
    let contentState = ContentState.createFromText(postContent);
    let initialEditor = EditorState.createWithContent(contentState,decorator);
    this.state = {
      editorState: initialEditor,
      showURLInput: false,
      urlValue: '',
    };

    this.focus = () => this.refs.editor.focus();
    this.onChange = (editorState) => {
      console.log("Change");
      this.setState({editorState});
      var selectionState = editorState.getSelection();
      var anchorKey = selectionState.getAnchorKey();
      var currentContent = editorState.getCurrentContent();
      var currentContentBlock = currentContent.getBlockForKey(anchorKey);
      var start = selectionState.getStartOffset();
      var end = selectionState.getEndOffset();
      var selectedText = currentContentBlock.getText().slice(start, end);
      console.log(selectedText);
      //this.state.selectedText = selectedText;
      if (selectedText.length>0){
        this.setState({
          selectedText: selectedText,
          urlValue:selectedText,
          showURLInput:true,
        });
        //this._promptForLink();
      }
      else {
        this.setState({
          showURLInput:false,
        });
      }
    };
    this.logState = () => {
      const content = this.state.editorState.getCurrentContent();
      console.log(convertToRaw(content));
    };

    this.promptForLink = this._promptForLink.bind(this);
    this.onURLChange = (e) => this.setState({urlValue: e.target.value});
    this.confirmLink = this._confirmLink.bind(this);
    this.onLinkInputKeyDown = this._onLinkInputKeyDown.bind(this);
    this.removeLink = this._removeLink.bind(this);
    this.saveCorrection = this._saveCorrection.bind(this);
  }

  _promptForLink(e) {
    console.log("Prompt for link");
    //e.preventDefault();
    //e.stopPropagation();
    const {editorState} = this.state;
    const selection = editorState.getSelection();
    if (!selection.isCollapsed()) {
      const contentState = editorState.getCurrentContent();
      const startKey = editorState.getSelection().getStartKey();
      const startOffset = editorState.getSelection().getStartOffset();
      const blockWithLinkAtBeginning = contentState.getBlockForKey(startKey);
      const linkKey = blockWithLinkAtBeginning.getEntityAt(startOffset);

      let url = '';
      if (linkKey) {
        const linkInstance = contentState.getEntity(linkKey);
        url = linkInstance.getData().url;
      }

      this.setState({
        showURLInput: true,
        urlValue: url,
      }, () => {
        setTimeout(() => this.refs.url.focus(), 0);
      });
    }
  }

  _confirmLink(e) {
    e.preventDefault();
    const {editorState, urlValue} = this.state;
    const contentState = editorState.getCurrentContent();
    const contentStateWithEntity = contentState.createEntity(
      'LINK',
      'MUTABLE',
      {url: urlValue}
    );
    const entityKey = contentStateWithEntity.getLastCreatedEntityKey();
    const newEditorState = EditorState.set(editorState, { currentContent: contentStateWithEntity });
    this.setState({
      editorState: RichUtils.toggleLink(
        newEditorState,
        newEditorState.getSelection(),
        entityKey
      ),
      showURLInput: false,
      urlValue: '',
    }, () => {
      setTimeout(() => this.refs.editor.focus(), 0);
    });
  }

  _onLinkInputKeyDown(e) {
    if (e.which === 13) {
      this._confirmLink(e);
    }
  }

  _removeLink(e) {
    e.preventDefault();
    const {editorState} = this.state;
    const selection = editorState.getSelection();
    if (!selection.isCollapsed()) {
      this.setState({
        editorState: RichUtils.toggleLink(editorState, selection, null),
      });
    }
  }

  handleTextCorrectionChange(e){
    this.setState({selectedText:e.target.value});
  }

  _saveCorrection(e){
    e.preventDefault();
    const { editorState } = this.state;
    const myHeaders = new Headers();
    let entityMap = editorState.getCurrentContent().getEntityMap();
    let data = {post_id:post_id};
    const requestMap = {method:'POST',headers:myHeaders,mode:'cors',cache:'default',body:JSON.stringify(data)};
    //console.log(entityMap);
    //console.log(convertToRaw(editorState.getCurrentContent()));
    //console.log(JSON.stringify(convertToRaw(editorState.getCurrentContent())));
    fetch(saveURL,requestMap).then(res=>{console.log(res);});
  }
  render() {
    let urlInput;
    if (this.state.showURLInput) {
      urlInput =(
        <div style={styles.urlInputContainer}>
          <span style={styles.selectedText}>{ this.state.selectedText }</span>
          <input
            onChange={this.onURLChange}
            ref="url"
            style={styles.urlInput}
            type="text"
            value={this.state.urlValue}
            onKeyDown={this.onLinkInputKeyDown}
            />
          <button type="button" onMouseDown={this.confirmLink}>
            түзетуге жібер
          </button>
      </div>);
    }

    return (
      <div style={styles.root}>
        <div style={{marginBottom: 10}}>
          Текст
        </div>
        <div style={styles.buttons}>
          <button
            type="button"
            onMouseDown={this.promptForLink}
            style={{marginRight: 10}}>
            Дұрыста
          </button>
          
        </div>
        {urlInput}
        <div style={styles.editor} onClick={this.focus}>
          <Editor
            editorState={this.state.editorState}
            onChange={this.onChange}
            placeholder="Текстіңізді осы жаққа енгізіңіз ... "
            ref="editor"
            />
        </div>
        <button type="button" onClick={this.saveCorrection}>Сақта</button>
        {/*<input type="text" value={this.state.selectedText} onChange={this.handleTextCorrectionChange}/>*/}
      </div>
    );
  }
}

function findLinkEntities(contentBlock, callback, contentState) {
  contentBlock.findEntityRanges(
    (character) => {
      const entityKey = character.getEntity();
      return (
        entityKey !== null &&
        contentState.getEntity(entityKey).getType() === 'LINK'
      );
    },
    callback
  );
}

const Link = (props) => {
  const {url} = props.contentState.getEntity(props.entityKey).getData();
  return (
    <span style={styles.fixedSpan}>
      <span style={ styles.incorrect}>{props.children}</span>
      <span style={ styles.fix}>({url})</span>
    </span>
  );
};

const styles = {
  incorrect:{
    textDecoration:'line-through',
  },
  fixedSpan:{
    position:'relative',
  },
  fix: {
    position:'absolute',top:-10,left:0,fontSize:12,
  },
  root: {
    fontFamily: '\'Georgia\', serif',
    padding: 20,
    width: 600,
  },
  buttons: {
    marginBottom: 10,
  },
  urlInputContainer: {
    marginBottom: 10,
    display:'flex',
    alignItems:'center',
  },
  selectedText:{
    paddingLeft:10,
    paddingRight:10,
    fontSize:16,
  },
  urlInput: {
    fontFamily: '\'Georgia\', serif',
    marginRight: 10,
    padding: 3,
  },
  editor: {
    border: '1px solid #ccc',
    cursor: 'text',
    minHeight: 80,
    padding: 10,
  },
  button: {
    marginTop: 10,
    textAlign: 'center',
  },
  link: {
    color: '#3b5998',
    textDecoration: 'underline',
  },
};
/*
ReactDOM.render(
  <LinkEditorExample />,
  document.getElementById('target')
);*/
if (document.getElementById('corrector_field')) {
    render(<CorrectorField />, document.getElementById('corrector_field'));
}
