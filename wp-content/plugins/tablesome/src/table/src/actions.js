import{get}from"svelte/store";import utils from"./utils";class ActionsHandler{store;ActionsList=[];constructor(e){this.store=e}doAction(e){switch(e.type){case"ENTER_KEY_IN_CELL":this.enterKeyPressedInCell(e);break;case"TAB_KEY_IN_CELL":this.tabKeyPressedInCell(e);break;case"CHANGE_NAME_OF_COLUMN":this.changeNameOfColumn(e);break;case"ADD_COLUMN":this.addColumn(e);break;case"MOVE_COLUMN":this.moveColumn(e);break;case"DELETE_COLUMN":this.deleteColumn(e);break;case"DUPLICATE_COLUMN":this.duplicateColumn(e);break;case"ADD_ROW":this.addRow(e);break;case"DELETE_ROW":this.deleteRow(e);break;case"DUPLICATE_ROW":this.duplicateRow(e);break;case"DRAGGED_ROW":this.draggedRow(e);break;case"CHANGE_CELL_TYPE":this.cellTypeChange(e);break;case"CHANGE_COLUMN_OPTIONS":this.updateColumnOptions(e);break;case"UPDATE_CURRENT_ROW_AND_CELL":this.updateCurrentRowAndCell(e);break;case"UPDATE_CURRENT_EDITABLE_ROW":this.updateCurrentEditableRow(e);break;case"UPDATE_CELL_DATA":this.updateCellData(e);break;case"GO_TO_NEXT_PAGE":this.goToNextPage(e);break;case"CHANGE_CURRENT_PAGE":this.changeCurrentPage(e);break;case"CHANGE_SORT_ORDER":this.changeSortOrder(e);break;case"CHANGE_SEARCH_QUERY":this.changeSearchQuery(e);break;case"CHANGE_OPTION_STATUS":this.changeOptionStatus(e);break;case"ADD_FILTER":this.addFilter(e);break;case"DELETE_FILTER":this.deleteFilter(e);break;case"UPDATE_FILTER":this.updateFilter(e);break;case"UPDATE_FILTERS":this.updateFilters(e);break;case"UPDATE_EDITOR_STATE":this.updateEditorState(e);break;case"SET_DISPLAY_FIELD":this.setDisplayField(e);break;case"SET_STYLE_FIELD":this.setStyleField(e);break;case"SET_ACCESS_CONTROL":this.setAccessControlField(e)}}addAction(e){return e.action_id="",actionsList.push(e),e.action_id}removeAction(e){}updateAction(e,t){}preventAction(e){}asyncActions(e){}changeNameOfColumn(e){this.store.columnStore.changeColumnName(e.payload.columnName,e.payload.columnIndex)}addColumn(e){if(0!=get(this.store.filters).length)return void alert("Can't add the column because it is being used by the filter.");if(get(this.store.columnStore.columns).length==this.store.columnLimit)return void alert("You have exceeded the table column limit!");let t=e.payload;this.store.columnStore.add(t.columnIndex,t.direction)}moveColumn(e){if(0!=get(this.store.filters).length)return void alert("Can't add the column because it is being used by the filter.");let t=e.payload;this.store.columnStore.move(t.columnIndex,t.direction)}deleteColumn(e){0==get(this.store.filters).length?1!=get(this.store.columnStore.columns).length?confirm("Are you sure you want to delete the selected column?")&&this.store.columnStore.delete(e.payload.columnIndex):alert("Couldn't remove the column. Table must have one column atleast!"):alert("Can't remove the column because it is being used by the filter.")}duplicateColumn(e){get(this.store.columnStore.columns).length!=this.store.columnLimit?this.store.columnStore.duplicate(e.payload.columnIndex):alert("You have exceeded the table column limit!")}addRow(e){get(this.store.rowStore.rows).length!=this.store.rowLimit?this.store.rowStore.addRow(e.payload.rowIndex):alert("You have exceeded the table rows limit!")}deleteRow(e){if(1!=get(this.store.rowStore.rows).length){if(confirm("Are you sure you want to delete the selected row?")){const t=1==get(this.store.viewableRecords).length;this.store.rowStore.deleteRow(e.payload.rowIndex),this.store.setIsChangesMadeInTable(!0),t&&0!=e.payload.rowIndex&&this.goToPreviousPage()}}else alert("Couldn't remove the row. Table must have one row atleast!")}duplicateRow(e){get(this.store.rowStore.rows).length!=this.store.rowLimit?this.store.rowStore.recordDuplicate(e.payload.rowIndex):alert("You have exceeded the table rows limit!")}draggedRow(e){this.store.rowStore.recordDragged(e.payload.prevRowIndex,e.payload.nextRowIndex,e.payload.draggingRowIndex)}cellTypeChange(e){this.store.changeCellType(e.payload.columnIndex,e.payload.cellType)}updateColumnOptions(e){this.store.columnStore.changeColumnOptions(e.payload.columnIndex,e.payload.optionName,e.payload.optionValue)}enterKeyPressedInCell(e){const t=this,a=get(this.store.rowStore.rows),o=a.findIndex((t=>t.stateRecordID===e.payload.stateRecordID)),s=o+1,r=this._isLastRowOnPage(s),l=s>=a.length,i=s>=this.store.rowLimit;e.payload.rowIndex=s,this._canEditRowAndCell(e.payload)&&(setTimeout((function(){r&&!i&&t.goToNextPage(),l&&(e.payload.rowIndex=o,t.addRow(e))}),10),this.updateCurrentRowAndCell(e))}tabKeyPressedInCell(e){if("SHIFT_TAB_KEY_EVENT"==e.payload.keyEvent)return void this.shiftTabKeyPressedInCell(e);let t=parseInt(e.payload.rowIndex),a=0;const o=t+1,s=parseInt(e.payload.cellIndex)+1,r=o>=get(this.store.rowStore.rows).length,l=this._isLastColumnOnPage(s),i=this._isLastRowOnPage(o);l&&(t=o),l&&i&&!r&&this.goToNextPage(),l||(a=s),e.payload.rowIndex=t,e.payload.cellIndex=a,this._canEditRowAndCell(e.payload)&&this.updateCurrentRowAndCell(e)}shiftTabKeyPressedInCell(e){let t=0,a=0;const o=parseInt(e.payload.rowIndex),s=parseInt(e.payload.cellIndex),r=o-1,l=s-1,i=0==o,d=this._isFirstColumnOnPage(s),n=this._isFirstRowOnPage(o);d&&(t=r,a=get(this.store.columnStore.columns).length-1),d&&n&&!i&&(t=r,a=get(this.store.columnStore.columns).length-1,this.goToPreviousPage()),d||(t=o,a=l),e.payload.rowIndex=t,e.payload.cellIndex=a,this._canEditRowAndCell(e.payload)&&this.updateCurrentRowAndCell(e)}updateCurrentEditableRow(e){this.store.setActiveEditableRowIndex(e.payload.editableRowIndex)}updateCurrentRowAndCell(e){this.store.setActiveRowIndex(e.payload.rowIndex),this.store.setActiveCellIndex(e.payload.cellIndex)}updateCellData(e){this.store.updateCellValue(e.payload.data),this.store.setIsChangesMadeInTable(!0)}goToNextPage(){let e=get(this.store.currentPage)+1;this.store.setCurrentPage(e)}goToPreviousPage(){let e=get(this.store.currentPage)-1;this.store.setCurrentPage(e)}changeCurrentPage(e){this.store.setCurrentPage(e.payload.currentPage)}changeSortOrder(e){this.store.setActiveColumnIndex(e.payload.columnIndex),this.store.setSortField(e.payload.sortField),this.store.setSortOrder(e.payload.order),this.store.setActiveCellIndex(null)}changeSearchQuery(e){this.store.setSearchQuery(e.payload.searchQuery),this.store.setSortOrder(e.payload.sortOrder),this.store.setCurrentPage(e.payload.currentPage),this.store.setActiveCellIndex(null)}changeOptionStatus(e){this.store.setOptionStatus(e.payload)}addFilter(e){this.store.addFilter()}deleteFilter(e){this.store.deleteFilter(e.payload.index)}updateFilter(e){this.store.updateFilter(e.payload.filter,e.payload.index),this.store.setCurrentPage(e.payload.currentPage)}updateFilters(e){this.store.updateFilters(e.payload.values),this.store.setCurrentPage(e.payload.currentPage)}updateEditorState(e){this.store.updateEditorState(e.payload.id,e.payload.value)}setDisplayField(e){this.store.setDisplayField(e.payload.id,e.payload.value)}setAccessControlField(e){this.store.setAccessControlField(e.payload.id,e.payload.value,e.payload.type?e.payload.type:"")}setStyleField(e){this.store.setStyleField(e.payload.id,e.payload.value);let t=e.payload.value,a={};e.payload.extra&&"extra"in e.payload&&"themes"in e.payload.extra&&(a=e.payload.extra.themes[t]?e.payload.extra.themes[t]:{}),e.payload.extra&&"extra"in e.payload&&"values"in e.payload.extra&&(t=e.payload.extra.values[t]?e.payload.extra.values[t]:t),e.payload.extra&&"extra"in e.payload&&"fields"in e.payload.extra&&e.payload.extra.fields.forEach((e=>{a[e]=t}));for(const[e,t]of Object.entries(a))this.store.setStyleField(e,t)}_isLastRowOnPage(e){const t=parseInt(this.store.numOfRecordsPerPage),a=e%t;return a<=t&&0==a}_isLastColumnOnPage(e){return e==get(this.store.columnStore.columns).length}_isFirstRowOnPage(e){const t=e+1,a=parseInt(this.store.numOfRecordsPerPage),o=t%a;return o<a&&1==o}_isFirstColumnOnPage(e){return e<=0}_canEditRowAndCell=e=>{if("editor"==get(this.store.mode))return!0;const t=e.derivedPermissions;if(!(t&&utils.getBool(t.enable_frontend_editing)))return!1;const a=get(this.store.columnStore.columns),o=get(this.store.rowStore.rows)[e.rowIndex],s=!(!o||!o.is_editable)&&o.is_editable;let r=t.editable_columns.includes(a[e.cellIndex].id);r=0===t.editable_columns.length||r;return r&&s}}export default ActionsHandler;